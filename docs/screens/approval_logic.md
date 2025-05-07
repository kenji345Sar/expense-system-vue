# 承認機能ロジック仕様書

---

## 概要

この文書は、経費精算システムにおける「承認機能」のロジック仕様を記述する。対象は各カテゴリ（交通費・出張旅費・接待交際費・備品・消耗品費）に共通する承認処理である。

---

## ステータス遷移ルール

| 遷移元ステータス | 遷移先ステータス | 実行者     | 条件                             |
|------------------|------------------|------------|----------------------------------|
| `submitted`      | `approved`       | 承認者     | ログインユーザーが承認者であること |

---

## 権限チェックロジック

- 承認を実行できるのは `is_approver = true` のユーザーのみ
- 自身が承認対象のレコードに対してのみ許可される
- Laravelの Policy を用いて制御

### ポリシー定義例（ApprovalPolicy.php）

```php
public function approve(User $user, Expense $expense)
{
    return $user->is_approver && $expense->status === 'submitted';
}
```

---

## 承認処理フロー

1. 一覧画面の「承認」ボタンがクリックされる
2. Controller の `ApprovalController@approve()` に POST
3. バリデーション（ステータスが `submitted` であること等）
4. ステータスを `approved` に更新
5. 成功時、リダイレクトとメッセージ表示

### コントローラ例

```php
public function approve(Request $request, $id)
{
    $expense = Expense::findOrFail($id);

    $this->authorize('approve', $expense);

    if ($expense->status !== 'submitted') {
        return redirect()->back()->withErrors('承認可能な状態ではありません');
    }

    $expense->status = 'approved';
    $expense->approved_by = auth()->id();
    $expense->approved_at = now();
    $expense->save();

    return redirect()->route('expenses.index')->with('success', '承認が完了しました');
}
```

---

## 今後の拡張案

- 承認者コメントの追加
- 承認ログの履歴管理（別テーブルに記録）
- 差戻し機能（`rejected` ステータスなど）

---
