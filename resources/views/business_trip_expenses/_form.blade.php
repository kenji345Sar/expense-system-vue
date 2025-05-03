@csrf
@if(isset($edit) && $edit)
  @method('PUT')
@endif

<div>
  <label for="business_trip_date" class="block font-medium">日付</label>
  <input type="date" name="business_trip_date" id="business_trip_date"
         value="{{ old('business_trip_date', $business_trip_expense->business_trip_date ?? '') }}"
         class="w-60 border rounded px-3 py-2" required>
</div>

<div>
  <label for="departure" class="block font-medium">出発地</label>
  <input type="text" name="departure" id="departure"
         value="{{ old('departure', $business_trip_expense->departure ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="destination" class="block font-medium">到着地</label>
  <input type="text" name="destination" id="destination"
         value="{{ old('destination', $business_trip_expense->destination ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="purpose" class="block font-medium">目的</label>
  <input type="text" name="purpose" id="purpose"
         value="{{ old('purpose', $business_trip_expense->purpose ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="amount" class="block font-medium">金額</label>
  <input type="number" name="amount" id="amount" step="0.01"
         value="{{ old('amount', $business_trip_expense->amount ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="note" class="block font-medium">備考（任意）</label>
  <textarea name="note" id="note" rows="3"
            class="w-full border rounded px-3 py-2">{{ old('note', $business_trip_expense->note ?? '') }}</textarea>
</div>
