@csrf
@if(isset($edit) && $edit)
  @method('PUT')
@endif

<div>
  <label for="use_date" class="block font-medium">利用日</label>
  <input type="date" name="use_date" id="use_date"
         value="{{ old('use_date', $transportation_expense->use_date ?? '') }}"
         class="w-60 border rounded px-3 py-2" required>
</div>

<div>
  <label for="departure" class="block font-medium">出発地</label>
  <input type="text" name="departure" id="departure"
         value="{{ old('departure', $transportation_expense->departure ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="arrival" class="block font-medium">到着地</label>
  <input type="text" name="arrival" id="arrival"
         value="{{ old('arrival', $transportation_expense->arrival ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="route" class="block font-medium">経路（任意）</label>
  <input type="text" name="route" id="route"
         value="{{ old('route', $transportation_expense->route ?? '') }}"
         class="w-full border rounded px-3 py-2">
</div>

<div>
  <label for="amount" class="block font-medium">金額</label>
  <input type="number" name="amount" id="amount" step="0.01"
         value="{{ old('amount', $transportation_expense->amount ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="note" class="block font-medium">備考（任意）</label>
  <textarea name="note" id="note" rows="3"
            class="w-full border rounded px-3 py-2">{{ old('note', $transportation_expense->note ?? '') }}</textarea>
</div>
