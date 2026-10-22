<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('key', 60)->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question_ar', 300);
            $table->text('answer_ar');
            $table->string('question_en', 300)->nullable();
            $table->text('answer_en')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('subtitle', 120)->nullable(); // e.g. "أم" / "الكويت" / course name
            $table->text('quote');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();

        DB::table('site_settings')->insert(collect([
            'whatsapp'      => '96555665161',
            'phone'         => '96599880140',
            'address_ar'    => 'الكويت - برج أحمد - بجوار المستشفى الأميري',
            'address_en'    => 'Kuwait - Burj Ahmed - near Al-Amiri Hospital',
            'announcement_ar' => null, // empty = built from the featured course
            'announcement_en' => null,
        ])->map(fn ($value, $key) => ['key' => $key, 'value' => $value, 'created_at' => $now, 'updated_at' => $now])->values()->all());

        // The homepage FAQ that used to be hardcoded
        $faqs = [
            ['كيف أسجل في الدورات؟', 'يمكنك التسجيل عبر الموقع الإلكتروني. اختر الدورة المناسبة لك واضغط على "سجل الآن" لإتمام عملية التسجيل والدفع.', 'How do I register for courses?', 'You can register through the website. Choose your course and click "Register Now" to complete registration and payment.'],
            ['هل الدورات مسجلة أم مباشرة؟', 'نقدم دورات مسجلة يمكنك مشاهدتها في أي وقت يناسبك، بالإضافة إلى بعض الدورات المباشرة التي يتم الإعلان عنها بشكل دوري.', 'Are courses recorded or live?', 'We offer recorded courses you can watch anytime, plus some live courses announced periodically.'],
            ['هل أحصل على شهادة بعد إتمام الدورة؟', 'نعم، يحصل كل متدرب على شهادة إتمام معتمدة من مركز مطمئنة بعد إنهاء جميع محتويات الدورة بنجاح.', 'Do I get a certificate after completing the course?', 'Yes, every trainee receives a completion certificate accredited by Motmaena Center after finishing all course content.'],
            ['ما هي طرق الدفع المتاحة؟', 'نقبل الدفع عبر البطاقات البنكية (فيزا، ماستركارد)، كي نت، وApple Pay. كما يمكن الدفع عبر التحويل البنكي.', 'What payment methods are available?', 'We accept bank cards (Visa, Mastercard), KNET, Apple Pay, and bank transfers.'],
            ['هل يمكنني مشاهدة الدورة أكثر من مرة؟', 'بالتأكيد! بمجرد التسجيل في الدورة، يمكنك إعادة مشاهدة المحتوى عدد غير محدود من المرات طوال فترة اشتراكك.', 'Can I watch the course more than once?', 'Absolutely! Once enrolled, you can re-watch the content unlimited times throughout your subscription period.'],
        ];
        foreach ($faqs as $i => [$qa, $aa, $qe, $ae]) {
            DB::table('faqs')->insert(['question_ar' => $qa, 'answer_ar' => $aa, 'question_en' => $qe, 'answer_en' => $ae, 'sort' => $i, 'created_at' => $now, 'updated_at' => $now]);
        }

        Schema::table('course_registrations', function (Blueprint $table) {
            $table->string('utm_source', 100)->nullable()->after('payment_method');
            $table->string('utm_medium', 100)->nullable()->after('utm_source');
            $table->string('utm_campaign', 150)->nullable()->after('utm_medium');
            $table->string('referrer', 255)->nullable()->after('utm_campaign');
            $table->timestamp('followed_up_at')->nullable()->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->dropColumn(['utm_source', 'utm_medium', 'utm_campaign', 'referrer', 'followed_up_at']);
        });
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('site_settings');
    }
};
