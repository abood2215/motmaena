<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** The site sells what the center offers today (marital, parenting, social consultations); psychological consultations show only as "coming soon". */
class AvailableServicesTest extends TestCase
{
    use RefreshDatabase;

    private const HELP = 'مرحبًا مركز مطمئنة، أرغب في معرفة نوع الاستشارة المناسبة لاحتياجي.';

    public function test_homepage_leads_with_the_consultations_available_today(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('<h1 class="lx-h1 mb-5">نحو علاقات أكثر اتزانًا وحياة أسرية أكثر طمأنينة</h1>', $html);
        foreach (['استشارات زوجية', 'استشارات تربوية', 'استشارات اجتماعية', 'لست متأكدًا من الاستشارة المناسبة؟'] as $text) {
            $this->assertStringContainsString($text, $html);
        }
        // "Help me choose" opens WhatsApp with the agreed message
        $this->assertStringContainsString('wa.me/96556551112?text=' . rawurlencode(self::HELP), $html);
        $this->assertSame('<title>استشارات زوجية وتربوية واجتماعية في الكويت | مركز مطمئنة</title>', $this->title($html));
    }

    public function test_open_courses_sit_right_under_the_hero(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $strip = strpos($html, 'id="open-courses"');
        $services = strpos($html, 'كيف نقدر نساعدك؟');
        $this->assertNotFalse($strip);
        $this->assertLessThan($services, $strip, 'the open courses come before the services');

        // A link in the hero jumps to them, and each course row links to its own page
        $this->assertStringContainsString('href="#open-courses"', $html);
        $this->assertMatchesRegularExpression('/التسجيل مفتوح: (دورة قادمة|دورتان قادمتان|\d+ دورات قادمة|\d+ دورة قادمة)/u', $html);
        $section = substr($html, $strip, $services - $strip);
        $this->assertStringContainsString(route('course.register', 'anger-management'), $section);
    }

    public function test_psychological_consultations_are_only_coming_soon(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        // The card says "coming soon" and its only button asks to be told at launch
        $card = $this->between($html, 'استشارات نفسية</h3>', '</article>');
        $this->assertStringContainsString('نعمل حاليًا على تجهيز خدمة الاستشارات النفسية', $card);
        $this->assertStringContainsString('اعرف عند الإطلاق', $card);
        $this->assertStringNotContainsString('احجز', $card);
        $this->assertStringNotContainsString(route('consultations'), $card);
        $this->assertStringContainsString('الاستشارات النفسية قريبًا في مركز مطمئنة', $html);

        // Nothing on the site books a psychological consultation
        $consult = $this->get('/consultations')->assertOk()->getContent();
        $form = $this->between($consult, 'id="booking-form"', '</form>');
        $this->assertStringContainsString('<option value="استشارة زوجية">', $form);
        $this->assertDoesNotMatchRegularExpression('/<option[^>]*>[^<]*نفسي/u', $form);
        $this->assertStringContainsString('هل تتوفر استشارات نفسية؟', $consult);
        $this->assertStringContainsString('خدمة الاستشارات النفسية غير متاحة حاليًا', $consult);

        // The Dr. Tariq request lists marital, parenting, social and life topics only
        // (his professional title, part of his record, is the only "psychiatry" word allowed there)
        $drt = str_replace(config('doctor.title.ar'), '', $this->between($consult, 'id="dr-tariq"', '</section>'));
        $this->assertStringNotContainsString('نفسي', $drt);

        // Titles and descriptions do not promise psychological consultations
        foreach (['/', '/consultations', '/sessions', '/packages', '/courses'] as $page) {
            $page = $this->get($page)->getContent();
            $this->assertStringNotContainsString('نفسي', $this->title($page));
            preg_match('#<meta name="description" content="([^"]*)"#u', $page, $m);
            $this->assertStringNotContainsString('نفسي', $m[1] ?? '');
        }
    }

    public function test_privacy_wording_promises_only_what_the_policy_covers(): void
    {
        $consult = $this->get('/consultations')->assertOk()->getContent();
        $this->assertStringContainsString('يحرص المركز على التعامل مع معلومات العملاء بخصوصية وفق السياسات والإجراءات المعتمدة لديه.', $consult);
        $this->assertStringNotContainsString('جلساتنا سرية تماماً', $consult);
        $this->assertStringNotContainsString('50 دقيقة', $this->between($consult, 'data-track-location="hero"', '</section>'));
        // Session length as confirmed by the center
        $this->assertStringContainsString('مدة الجلسة من 45 دقيقة إلى ساعة.', $consult);
        $this->assertStringNotContainsString('50 دقيقة', $consult);
    }

    public function test_prices_and_hours_given_by_the_center_are_shown(): void
    {
        $consult = $this->get('/consultations')->assertOk()->getContent();
        foreach (['جلسة فردية 50 د.ك', 'كم سعر الاستشارة؟', 'الجلسة الفردية مع أخصائي 50 د.ك', 'الجلسة الأولى 80 د.ك، وجلسة المتابعة 60 د.ك', 'السبت – الخميس: 9 صباحًا – 9 مساءً · الجمعة مغلق'] as $text) {
            $this->assertStringContainsString($text, $consult, $text);
        }
        // Dr. Tariq request box (homepage and consultations) states his prices
        $this->assertStringContainsString('الجلسة الأولى 80 د.ك · جلسة المتابعة 60 د.ك', $consult);

        $home = $this->get('/')->assertOk()->getContent();
        $this->assertStringContainsString('جلسة فردية مع أخصائي · 50 د.ك', $home);
        $this->assertStringContainsString('كم سعر الاستشارة؟', $home);

        // Opening hours in the footer of every page
        foreach (['/', '/courses', '/sessions', '/packages', '/policies'] as $page) {
            $this->get($page)->assertSee('السبت – الخميس: 9 صباحًا – 9 مساءً · الجمعة مغلق');
        }
    }

    private function title(string $html): string
    {
        preg_match('#<title>.*?</title>#su', $html, $m);
        return $m[0] ?? '';
    }

    private function between(string $html, string $from, string $to): string
    {
        $start = strpos($html, $from);
        $this->assertNotFalse($start, "missing: $from");
        $end = strpos($html, $to, $start);
        return substr($html, $start, ($end === false ? strlen($html) : $end) - $start);
    }
}
