# ドキュメント索引

このディレクトリには、経費精算システムの各種ドキュメントが格納されています。

## ディレクトリ構成

```
docs/
├── domain/         業務・データ仕様
├── screens/        画面仕様
├── devops/         開発環境・運用関連
└── history/        進捗・経緯のメモ
```

## domain/ - 業務・データ仕様

業務要件、データモデル、ユースケースなど、システムのドメイン知識に関するドキュメント

- [requirements.md](domain/requirements.md) - システム要件定義
- [er_diagram.md](domain/er_diagram.md) - ER図とデータベース設計
- [use_cases.md](domain/use_cases.md) - ユースケース定義

## screens/ - 画面仕様

各画面の詳細仕様とUI設計に関するドキュメント

### 📂 screens/_common/ - 共通仕様

全経費種別に共通する画面仕様・ロジック・設計方針

- [all_index.md](screens/_common/all_index.md) - 全経費一覧画面（カテゴリ横断）
- [create_shared.md](screens/_common/create_shared.md) - 経費新規作成画面（共通構成）
- [edit_shared.md](screens/_common/edit_shared.md) - 経費編集画面（共通構成）
- [approval_logic.md](screens/_common/approval_logic.md) - 承認機能ロジック仕様
- [attachment_spec.md](screens/_common/attachment_spec.md) - ファイル添付仕様
- [design_policy.md](screens/_common/design_policy.md) - 画面設計方針
- [routing_mapping.md](screens/_common/routing_mapping.md) - ルーティングとURLマッピング
- [menu.md](screens/_common/menu.md) - メニュー画面（カテゴリ選択）
- [web.php](screens/_common/web.php) - ルーティング定義（参考）

### 📂 screens/expenses/ - 経費種別ごとの画面仕様

各経費種別に固有の画面仕様

#### 出張旅費 (business_trip)
- [index.md](screens/expenses/business_trip/index.md) - 一覧画面
- [create_spec.md](screens/expenses/business_trip/create_spec.md) - 新規作成仕様
- [edit_spec.md](screens/expenses/business_trip/edit_spec.md) - 編集仕様
- [create_detail.md](screens/expenses/business_trip/create_detail.md) - 新規作成詳細（補助資料）

#### 交通費 (transportation)
- [index.md](screens/expenses/transportation/index.md) - 一覧画面

#### 接待交際費 (entertainment)
- [index.md](screens/expenses/entertainment/index.md) - 一覧画面

#### 備品・消耗品費 (supplies)
- [index.md](screens/expenses/supplies/index.md) - 一覧画面

## devops/ - 開発環境・運用関連

開発環境のセットアップ、デプロイ、インフラに関するドキュメント

- [dev2_env.md](devops/dev2_env.md) - dev2 開発環境の構築・運用ガイド
- [run_on_aws.md](devops/run_on_aws.md) - AWS環境でのセットアップ手順

## history/ - 進捗・経緯のメモ

開発の進捗状況、変更履歴、議事録など

- [expense_form_progress.md](history/expense_form_progress.md) - 経費フォーム開発の進捗記録

---

## ドキュメント更新ルール

- **新しい画面を追加する場合**:
  - 全経費種別に共通する画面 → `screens/_common/` に追加
  - 経費種別固有の画面 → `screens/expenses/{type}/` に追加
  - このREADMEも合わせて更新する
- **新しい経費種別を追加する場合**:
  - `screens/expenses/{new_type}/` ディレクトリを作成
  - 最低限 `index.md` (一覧画面仕様) を作成
  - このREADMEに新種別のセクションを追加
- **システム要件やデータモデルの変更**:
  - `domain/` 配下のドキュメントを更新する
- **開発環境やデプロイ手順の変更**:
  - `devops/` 配下のドキュメントを更新する
