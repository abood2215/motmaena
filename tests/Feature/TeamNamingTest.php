<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** The team is named as the management confirmed: specialists, with Prof. Dr. Tariq's titles unchanged. */
class TeamNamingTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_consultations_team_uses_the_confirmed_titles(): void
    {
        $ar = $this->withSession(['locale' => 'ar'])->get('/consultations')->assertOk();
        $ar->assertSee('فريق الأخصائيين')
            ->assertSee('أخصائي تربوي')->assertSee('أخصائي اجتماعي')->assertSee('أخصائي تطوير ذات')
            ->assertSee('أ.د. طارق الحبيب')->assertSee('بروفيسور واستشاري الطب النفسي');
        foreach (['مرشد تربوي', 'تربوي معتمد', 'مستشار اجتماعي', 'مدرّب تطوير ذات', 'مدرّب معتمد',
                  'متخصص معتمد', 'متخصصون معتمدون', 'المستشار', 'المستشارون', 'مستشار آخر'] as $old) {
            $ar->assertDontSee($old);
        }

        $en = $this->withSession(['locale' => 'en'])->get('/consultations')->assertOk();
        $en->assertSee('Our Specialists')
            ->assertSee('Educational Specialist')->assertSee('Social Specialist')->assertSee('Self-Development Specialist')
            ->assertSee('Prof. Tariq Al-Habib');
        foreach (['Educational Advisor', 'Certified Educational Counselor', 'Social Consultant',
                  'Self-Development Coach', 'Certified Life Coach', 'certified advisor', 'Certified professionals'] as $old) {
            $en->assertDontSee($old);
        }
    }

    public function test_other_pages_say_specialist(): void
    {
        $this->withSession(['locale' => 'ar'])->get('/')->assertOk()
            ->assertSee('تربوي · اجتماعي · تطوير ذات')->assertSee('بإشراف أخصائيين');

        $this->withSession(['locale' => 'ar'])->get('/sessions')->assertOk()
            ->assertSee('تحدث مع أخصائي')->assertSee('أخصائيونا مستعدون')->assertDontSee('استشاريونا');
        $this->withSession(['locale' => 'en'])->get('/sessions')->assertOk()
            ->assertSee('Our specialists are ready')->assertDontSee('specialized consultants');

        $this->withSession(['locale' => 'ar'])->get('/packages')->assertOk()
            ->assertSee('أو احجز استشارة مع الأخصائي');
    }
}
