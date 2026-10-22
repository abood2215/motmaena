<div>
  <label>الاسم *</label>
  <input name="name" value="{{ $t->name }}" required maxlength="120" placeholder="أم محمد">
</div>
<div>
  <label>وصف قصير</label>
  <input name="subtitle" value="{{ $t->subtitle }}" maxlength="120" placeholder="ولية أمر / متدربة في دورة إدارة الغضب">
</div>
<div class="full">
  <label>الرأي *</label>
  <textarea name="quote" required maxlength="1000">{{ $t->quote }}</textarea>
</div>
<div>
  <label>التقييم</label>
  <select name="rating">
    @for($i = 5; $i >= 1; $i--)
      <option value="{{ $i }}" @selected($t->rating == $i)>{{ str_repeat('★', $i) }}</option>
    @endfor
  </select>
</div>
<div>
  <label>الترتيب</label>
  <input name="sort" type="number" min="0" value="{{ $t->sort }}">
</div>
<div class="full">
  <input type="hidden" name="is_active" value="0">
  <label class="check"><input type="checkbox" name="is_active" value="1" @checked($t->is_active)> ظاهر بالموقع</label>
</div>
