<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>دخول الإدارة — مطمئنة</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Tajawal', sans-serif;
  background: #0f0c0a;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
.login-box {
  background: #1e1a16;
  border: 1px solid #2e2820;
  border-radius: 24px;
  padding: 52px 44px;
  width: 100%;
  max-width: 400px;
  text-align: center;
  box-shadow: 0 24px 60px rgba(0,0,0,.5);
}
.logo {
  font-size: 32px;
  font-weight: 900;
  color: #b04141;
  margin-bottom: 4px;
  letter-spacing: -.5px;
}
.sub { font-size: 14px; color: #6b7280; margin-bottom: 36px; }
.field {
  position: relative;
  margin-bottom: 14px;
}
.field input {
  width: 100%;
  background: #2a2420;
  border: 1.5px solid #3a3028;
  border-radius: 14px;
  padding: 14px 18px;
  font-size: 15px;
  color: #f0ebe4;
  font-family: inherit;
  text-align: center;
  outline: none;
  transition: border-color .2s;
}
.field input:focus { border-color: #b04141; }
.error-msg {
  background: #2a1515;
  border: 1px solid rgba(176,65,65,.3);
  color: #f87171;
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 13px;
  margin-bottom: 14px;
}
button[type=submit] {
  width: 100%;
  background: #b04141;
  color: #fff;
  border: none;
  border-radius: 14px;
  padding: 15px;
  font-size: 16px;
  font-weight: 800;
  font-family: inherit;
  cursor: pointer;
  transition: background .2s, transform .1s;
  box-shadow: 0 4px 18px rgba(176,65,65,.4);
}
button[type=submit]:hover { background: #8a3232; transform: translateY(-1px); }
.hint {
  margin-top: 20px;
  font-size: 12px;
  color: #4b4540;
}
</style>
</head>
<body>
<div class="login-box">
  <div class="logo">مطمئنة</div>
  <div class="sub">لوحة تحكم الاستشارات — للإدارة فقط</div>

  @if($errors->has('password'))
    <div class="error-msg">{{ $errors->first('password') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <div class="field">
      <input type="password" name="password" placeholder="كلمة المرور" required autofocus>
    </div>
    <button type="submit">دخول</button>
  </form>

  <div class="hint">هذه الصفحة مخصصة للإدارة فقط</div>
</div>
</body>
</html>
