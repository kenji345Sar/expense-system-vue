
## 🚧 開発進捗・対応状況 (2025年時点)

### 📁 対象モジュール一覧

| モジュール         | 新規作成 | 複数明細 | 一覧画面 | 編集画面 | ステータス管理 | 備考                     |
|------------------|-----------|-------------|------------|--------------|----------------|--------------------------|
| 出張旅費           | ✅ 完成    | ⛔ 1明細固定  | ✅ 表示済    | ⚠ 実装未         | ⚠ 未対応           | 項目は簡単、UI統一未       |
| 交通費             | ✅ 完成    | ✅ 対応済      | ✅ 表示済    | ⚠ 編集未         | ⚠ 下書きのみ対応   | Alpine.js による複数対応済 |
| 接待交際費         | ⚠ 未実装  | ⛔ 予定あり     | ⚠ 未実装     | ⚠ 未実装         | ⛔ 未               | 現状テンプレート検討中     |
| 備品・消耗品費     | ⚠ 未実装  | ⛔ 予定なし     | ⚠ 未実装     | ⚠ 未実装         | ⛔ 未               | 単項目でシンプル予定       |

---

### 🗂 ステータス仕様整理

| ステータス | 入力画面選択 | 自動設定 | 編集可 | 操作者   | 実装状況     |
|------------|--------------|-----------|--------|----------|----------------|
| 下書き     | ✅ 初期状態  | ✅        | ✅     | 作成者   | ✅ 一部済     |
| 申請中     | ❌           | ✅（申請時）| ❌     | 作成者   | ⚠ 制御未       |
| 承認済     | ❌           | ✅（承認時）| ❌     | 管理者   | ⛔ 未対応      |

---

### ✅ 優先対応タスク (フェーズ分け)

#### 📌 フェーズ1：最低限動くフォーム完成（1カテゴリずつ）
- [x] 交通費申請：複数明細、登録、一覧
- [x] 出張旅費申請：1明細、登録、一覧
- [ ] 出張旅費編集画面の実装
- [ ] 一覧の整形（出力列の調整、統一）
- [ ] ステータス列の見た目のみ反映（値は固定）

#### 🔁 フェーズ2：共通仕様＆機能強化
- [ ] 各申請に「ステータス（下書き／申請中）」を持たせる（DB＆ルール）
- [ ] 登録・編集時にステータス制御
- [ ] Bladeの新規画面を共通化できるか再検討
- [ ] 承認・申請フローの整理（ユーザー権限とボタン表示制御）
