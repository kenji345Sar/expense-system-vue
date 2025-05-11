@csrf
@if(isset($edit) && $edit)
  @method('PUT')
@endif

<div>
  <label for="entertainment_date" class="block font-medium">利用日</label>
  <input type="date" name="entertainment_date" id="entertainment_date"
         value="{{ old('entertainment_date', $entertainment_expense->entertainment_date ?? '') }}"
         class="w-60 border rounded px-3 py-2" required>
</div>

<div>
  <label for="client_name" class="block font-medium">接待相手</label>
  <input type="text" name="client_name" id="client_name"
         value="{{ old('client_name', $entertainment_expense->client_name ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="place" class="block font-medium">場所</label>
  <input type="text" name="place" id="place"
         value="{{ old('place', $entertainment_expense->place ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="amount" class="block font-medium">金額</label>
  <input type="number" name="amount" id="amount"
         value="{{ old('amount', $entertainment_expense->amount ?? '') }}"
         class="w-full border rounded px-3 py-2" required>
</div>

<div>
  <label for="description" class="block font-medium">内容（任意）</label>
  <textarea name="description" id="description" rows="3"
            class="w-full border rounded px-3 py-2">{{ old('description', $entertainment_expense->description ?? '') }}</textarea>
</div>
