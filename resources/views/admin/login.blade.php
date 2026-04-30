<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>دخول الإدارة — مطمئنة</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Tajawal', sans-serif; background: #0f0c0a; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800&display=swap');
.login-box {
  background: #1e1a16;
  border: 1px solid #2e2820;
  border-radius: 20px;
  padding: 48px 40px;
  width: 100%;
  max-width: 400px;
  text-align: center;
}
.logo { font-size: 28px; font-weight: 900; color: #b04141; margin-bottom: 6px; }
.sub { font-size: 14px; color: #6b7280; margin-bottom: 36px; }
input[type=text], input[type=password] {
  width: 100%;
  background: #2a2420;
  border: 1.5px solid #3a3028;
  border-radius: 12px;
  padding: 14px 18px;
  font-size: 15px;
  color: #f0ebe4;
  font-family: inherit;
  text-align: center;
  margin-bottom: 16px;
  outline: none;
  transition: border-color .2s;
}
input:focus { border-color: #b04141; }
button {
  width: 100%;
  background: #b04141;
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 14px;
  font-size: 16px;
  font-weight: 800;
  font-family: inherit;
  cursor: pointer;
  transition: background .2s;
}
button:hover { background: #8a3232; }
.error { color: #f87171; font-size: 13px; margin-top: 12px; }
</style>
</head>
<body>
<div class="login-box">
  <div class="logo">مطمئنة</div>
  <div class="sub">لوحة تحكم الاستشارات</div>
  <form method="GET" action="{{ route('admin.consultations') }}">
    <input type="password" name="key" placeholder="كلمة المرور" required>
    <button type="submit">دخول</button>
  </form>
  @if(request()->has('key'))
    <div class="error">كلمة المرور غير صحيحة</div>
  @endif
</div>
</body>
</html>
