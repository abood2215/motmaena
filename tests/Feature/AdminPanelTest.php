<?php

namespace Tests\Feature;

use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\Faq;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $this->withSession(['admin_auth' => true]);
    }

    private function registration(array $attrs = []): CourseRegistration
    {
        return CourseRegistration::create($attrs + [
            'course_key' => 'anger-management', 'name' => 'Sara', 'phone' => '55500011',
            'original_amount' => 30, 'discount_amount' => 0, 'final_amount' => 30, 'status' => 'pending',
        ]);
    }

    public function test_all_admin_pages_render(): void
    {
        $this->registration(['status' => 'paid', 'paid_at' => now(), 'utm_source' => 'instagram']);

        foreach (['/admin', '/admin/courses', '/admin/courses/create', '/admin/content', '/admin/registrations', '/admin/registrations?status=followup', '/admin/discount-codes', '/admin/consultations'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->get('/admin')->assertSee('instagram');
    }

    public function test_a_new_featured_course_takes_over_the_homepage_and_gets_a_payment_page(): void
    {
        $this->post('/admin/courses', [
            'title_ar' => 'دورة الثقة بالنفس', 'title_en' => 'Self Confidence', 'slug' => '',
            'trainer_ar' => 'أ.د. طارق الحبيب', 'price' => '25', 'date' => '2026-12-02',
            'time_ar' => '6:00 - 8:00 مساءً', 'topics_ar' => "محور أول\nمحور ثاني",
            'is_active' => '1', 'is_featured' => '1',
        ])->assertRedirect(route('admin.courses'));

        $offer = CourseOffer::where('slug', 'self-confidence')->firstOrFail();
        $this->assertFalse(CourseOffer::where('slug', 'anger-management')->first()->is_featured, 'only one featured course');

        $this->get('/')->assertSee('دورة الثقة بالنفس')->assertSee('محور ثاني')->assertSee('/register/self-confidence', false);
        $this->get('/register/self-confidence')->assertOk()->assertSee('25.000');

        // Closing registration hides it
        $this->post("/admin/courses/{$offer->id}/toggle/is_active");
        $this->get('/register/self-confidence')->assertNotFound();
    }

    public function test_next_course_is_set_up_from_admin_without_code_changes(): void
    {
        $old = CourseOffer::where('slug', 'anger-management')->first();

        // "Duplicate as new course" pre-fills the form with the old design and content
        $this->get('/admin/courses/create?from=' . $old->id)->assertOk()
            ->assertSee('نسخة من')->assertSee('مفهوم الغضب وأنواعه')->assertSee('#1d4e89');

        $this->post('/admin/courses', [
            'title_ar' => 'دورة الذكاء العاطفي', 'title_en' => 'Emotional Intelligence', 'trainer_ar' => 'أ.د. طارق الحبيب',
            'price' => '35', 'date' => '2026-11-25', 'theme_color' => '#0F5E4A', 'badge_ar' => 'الدورة القادمة',
            'show_installments' => '0', 'is_active' => '1', 'is_featured' => '1',
        ])->assertSessionHasNoErrors();

        $page = $this->get('/')->assertOk();
        $page->assertSee('دورة الذكاء العاطفي')->assertSee('الدورة القادمة')->assertSee('--c1:#0f5e4a', false);
        $this->assertStringNotContainsString('قسّط على 4 دفعات', $page->getContent());
        $this->get('/register/emotional-intelligence')->assertOk()->assertSee('--c1:#6d1b2b', false); // checkout keeps the wine palette

        $this->post('/admin/courses', ['title_ar' => 'x', 'trainer_ar' => 'y', 'price' => 1, 'date' => '2026-12-01', 'theme_color' => 'red'])
            ->assertSessionHasErrors('theme_color');
    }

    public function test_content_settings_change_the_site(): void
    {
        $this->post('/admin/content/settings', [
            'whatsapp' => '5555 1234', 'phone' => '+965 9999 0000',
            'address_ar' => 'عنوان جديد', 'announcement_ar' => 'خصم خاص هذا الأسبوع',
        ])->assertSessionHasNoErrors();

        $this->get('/')->assertSee('wa.me/96555551234', false)->assertSee('خصم خاص هذا الأسبوع')->assertSee('عنوان جديد');
        $this->get('/consultations')->assertSee('wa.me/96555551234', false);
    }

    public function test_faq_and_testimonials_are_managed_from_admin(): void
    {
        $this->get('/')->assertDontSee('ماذا يقول متدربونا');

        $this->post('/admin/content/testimonials', ['name' => 'أم محمد', 'quote' => 'دورة رائعة', 'rating' => 5, 'is_active' => '1']);
        $this->post('/admin/content/faqs', ['question_ar' => 'سؤال جديد؟', 'answer_ar' => 'جواب', 'is_active' => '1']);
        $first = Faq::orderBy('sort')->first();
        $this->put("/admin/content/faqs/{$first->id}", ['question_ar' => $first->question_ar, 'answer_ar' => $first->answer_ar, 'is_active' => '0']);

        $this->get('/')->assertSee('ماذا يقول متدربونا')->assertSee('دورة رائعة')->assertSee('سؤال جديد؟')->assertDontSee($first->question_ar);
        $this->assertSame(1, Testimonial::count());
    }

    public function test_follow_up_list_skips_people_who_paid_later(): void
    {
        $this->registration(['name' => 'Ali', 'phone' => '51111111']);
        $this->registration(['name' => 'Ali', 'phone' => '51111111']); // retried
        $this->registration(['name' => 'Mona', 'phone' => '52222222']);
        $this->registration(['name' => 'Mona', 'phone' => '52222222', 'status' => 'paid', 'paid_at' => now()]);

        $page = $this->get('/admin/registrations?status=followup')->assertOk();
        $page->assertSee('Ali')->assertDontSee('Mona');
        $this->assertSame(1, substr_count($page->getContent(), 'data-name="Ali"'));

        $ali = CourseRegistration::where('name', 'Ali')->first();
        $this->post("/admin/registrations/{$ali->id}/followed");
        $this->get('/admin/registrations?status=followup')->assertDontSee('data-name="Ali"', false);
    }

    public function test_registration_records_the_ad_source(): void
    {
        config(['services.myfatoorah.api_key' => 'k', 'services.myfatoorah.base_url' => 'https://mf.test']);
        \Illuminate\Support\Facades\Http::fake(['mf.test/*' => \Illuminate\Support\Facades\Http::response(['IsSuccess' => true, 'Data' => ['InvoiceId' => 1, 'InvoiceURL' => 'https://pay.test']])]);

        $this->get('/?utm_source=tiktok&utm_medium=ad&utm_campaign=anger');
        $this->post('/register/anger-management', ['name' => 'Test', 'phone' => '55566161']);

        $r = CourseRegistration::latest('id')->first();
        $this->assertSame('tiktok', $r->utm_source);
        $this->assertSame('anger', $r->utm_campaign);
    }
}
