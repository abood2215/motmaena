<div>
  <label>السؤال (عربي) *</label>
  <input name="question_ar" value="{{ $f->question_ar }}" required maxlength="300">
</div>
<div>
  <label>السؤال (إنجليزي)</label>
  <input name="question_en" value="{{ $f->question_en }}" maxlength="300" dir="ltr">
</div>
<div>
  <label>الجواب (عربي) *</label>
  <textarea name="answer_ar" required maxlength="3000">{{ $f->answer_ar }}</textarea>
</div>
<div>
  <label>الجواب (إنجليزي)</label>
  <textarea name="answer_en" maxlength="3000" dir="ltr">{{ $f->answer_en }}</textarea>
</div>
<div>
  <label>الترتيب</label>
  <input name="sort" type="number" min="0" value="{{ $f->sort }}">
</div>
<div>
  <input type="hidden" name="is_active" value="0">
  <label class="check" style="margin-top:22px"><input type="checkbox" name="is_active" value="1" @checked($f->is_active)> ظاهر بالموقع</label>
</div>
