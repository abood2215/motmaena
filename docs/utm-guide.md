# دليل روابط الحملات (UTM)

هذا الدليل لفريق التسويق: كيف نكتب رابط كل حملة، حتى نعرف من GA4 ولوحة التحكم من أين جاء كل زائر وكل تسجيل.

## القواعد
- كل الأسماء **بالإنجليزي، وبحروف صغيرة**، والكلمات بينها `-`. لا مسافات ولا عربي.
- **لا تضع أي بيانات شخصية في الرابط**، مثل الاسم أو الرقم.
- **استعمل UTM فقط في الروابط من خارج الموقع**: الإعلانات، والبايو، والستوري، ورسائل واتساب، وQR. لا تضعه في روابط بين صفحات الموقع.
- **انسخ القيم من الجداول أدناه كما هي.** أي اختلاف بسيط، مثل `Instagram` بدل `instagram`، يظهر في التقارير كمصدر منفصل.

## المعاملات

| المعامل | معناه | إلزامي |
|---|---|---|
| `utm_source` | المنصة | نعم |
| `utm_medium` | نوع الوصول (مدفوع أو مجاني أو مطبوع) | نعم |
| `utm_campaign` | اسم الحملة | نعم |
| `utm_content` | الإعلان أو المكان بالتحديد | اختياري |

## القيم المعتمدة

| القناة | `utm_source` | `utm_medium` |
|---|---|---|
| إعلان إنستغرام ممول | `instagram` | `paid_social` |
| بايو أو بوست أو ستوري إنستغرام (مجاني) | `instagram` | `social` |
| إعلان سناب ممول | `snapchat` | `paid_social` |
| ستوري أو حساب سناب (مجاني) | `snapchat` | `social` |
| إعلان تيك توك ممول | `tiktok` | `paid_social` |
| حساب تيك توك (مجاني) | `tiktok` | `social` |
| رسالة أو حالة واتساب | `whatsapp` | `social` |
| رمز QR مطبوع (بوستر، بروشور، كرت) | `qr` | `print` |

**اسم الحملة `utm_campaign`:** `الخدمة-السنة-الشهر`

| الحملة | القيمة |
|---|---|
| دورة الإسعافات النفسية الأولية، نوفمبر 2026 | `psych-first-aid-2026-11` |
| دورة مهارات التواصل، نوفمبر 2026 | `communication-skills-2026-11` |
| عرض الدورتين معاً، نوفمبر 2026 | `bundle-2026-11` |
| الاستشارات (حملة عامة) | `consultations-2026-11` |
| جلسات الأطفال | `sessions-2026-11` |
| الباقات | `packages-2026-11` |

**الإعلان بالتحديد `utm_content`:** وصف قصير للإعلان أو المكان، مثل:
- `story-video1` و`reel-dr-tariq`
- `bio-link`
- `poster-reception`

## أمثلة جاهزة

إعلان ستوري ممول على إنستغرام لدورة الإسعافات النفسية:
```
https://motmaena.motmaina-center.com/register/psychological-first-aid?utm_source=instagram&utm_medium=paid_social&utm_campaign=psych-first-aid-2026-11&utm_content=story-video1
```

رابط البايو في إنستغرام:
```
https://motmaena.motmaina-center.com/?utm_source=instagram&utm_medium=social&utm_campaign=bio&utm_content=bio-link
```

إعلان عرض الدورتين على سناب:
```
https://motmaena.motmaina-center.com/register/bundle/november-courses?utm_source=snapchat&utm_medium=paid_social&utm_campaign=bundle-2026-11
```

فيديو ممول على تيك توك لجلسات الأطفال:
```
https://motmaena.motmaina-center.com/sessions?utm_source=tiktok&utm_medium=paid_social&utm_campaign=sessions-2026-11&utm_content=video-parents
```

رسالة واتساب عن الاستشارات:
```
https://motmaena.motmaina-center.com/consultations?utm_source=whatsapp&utm_medium=social&utm_campaign=consultations-2026-11
```

بوستر QR في الاستقبال:
```
https://motmaena.motmaina-center.com/courses?utm_source=qr&utm_medium=print&utm_campaign=psych-first-aid-2026-11&utm_content=poster-reception
```

**أداة لبناء الروابط بدون أخطاء:** https://ga-dev-tools.google/campaign-url-builder/

**في إعدادات الإعلان:** ضع الرابط الكامل مع UTM في خانة "Website URL" أو "URL parameters"، في Meta وSnap وTikTok.

## أين يُحفظ المصدر

| المكان | المصدر محفوظ؟ |
|---|---|
| GA4 (كل الزيارات والأحداث) | نعم، تلقائياً |
| تسجيلات الدورات في لوحة التحكم | نعم: المصدر، والنوع، واسم الحملة |
| طلبات "بلّغني" | المصدر فقط |
| حجوزات الاستشارات وطلبات د. طارق | لا، في GA4 فقط (حفظه في لوحة التحكم يحتاج تعديلاً على قاعدة البيانات بموافقة) |

## قراءة النتائج في GA4

**كم زائر جاء من كل حملة:**
1. Reports ← Acquisition ← Traffic acquisition.
2. غيّر العمود الأول إلى **Session source / medium**، أو إلى **Session campaign**.
3. أعمدة Sessions وEngaged sessions تعطي عدد الزيارات وجودتها.

**كم تسجيل ودفع من كل حملة:**
- في نفس التقرير، اختر من عمود **Key events** الحدث `purchase`، أو `begin_checkout`، أو `generate_lead`.
- يشترط أن تكون هذه الأحداث معلّمة كـ Key events في Admin ← Events.

**مقارنة الإعلانات داخل الحملة:**
1. Explore ← Free form.
2. الأبعاد: Session campaign، وSession manual ad content.
3. المقاييس: Sessions، وKey events، وTotal revenue.

**ملاحظات:**
- التقارير العادية تتأخر **24 إلى 48 ساعة**. للتأكد الفوري استعمل Reports ← Realtime.
- زيارات QR تظهر تحت القناة **Unassigned** في تقرير القنوات الافتراضي. اقرأها من **Session source / medium**: تظهر هناك `qr / print`.
- في لوحة تحكم الموقع، عمود **المصدر** في صفحة التسجيلات يعرض المصدر واسم الحملة لكل تسجيل.

## اختبار رابط قبل نشر الحملة
1. افتح الرابط في نافذة تصفح خفي.
2. في GA4 ← Realtime: يجب أن يظهر المصدر والحملة خلال دقيقة.
3. اختياري: أكمل نموذج تسجيل حتى صفحة الدفع **بدون دفع**، باسم "اختبار".
   - يجب أن يظهر التسجيل في لوحة التحكم مع المصدر واسم الحملة.
   - احذفه أو علّمه بعد الاختبار.
