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

### 設計方針・共通仕様
- [screen_design_policy.md](screens/screen_design_policy.md) - 画面設計の方針
- [screen_routing_mapping.md](screens/screen_routing_mapping.md) - ルーティングとURLマッピング
- [approval_logic.md](screens/approval_logic.md) - 承認ロジック
- [attachment_spec.md](screens/attachment_spec.md) - 添付ファイル仕様

### 画面別仕様
- [メニュー画面.md](screens/メニュー画面.md) - メニュー画面
- [all_expenses_index.md](screens/all_expenses_index.md) - 全経費一覧画面
- [交通費一覧画面.md](screens/交通費一覧画面.md) - 交通費一覧
- [出張旅費一覧画面.md](screens/出張旅費一覧画面.md) - 出張旅費一覧
- [接待交際費一覧画面.md](screens/接待交際費一覧画面.md) - 接待交際費一覧
- [備品・消耗品費一覧画面.md](screens/備品・消耗品費一覧画面.md) - 備品・消耗品費一覧

### 登録・編集画面
- [create_expense_shared.md](screens/create_expense_shared.md) - 経費登録（共通）
- [edit_expense_shared.md](screens/edit_expense_shared.md) - 経費編集（共通）
- [create_expense_business_trip.md](screens/create_expense_business_trip.md) - 出張旅費登録
- [business_trip_create_spec.md](screens/business_trip_create_spec.md) - 出張旅費作成仕様
- [business_trip_edit_spec.md](screens/business_trip_edit_spec.md) - 出張旅費編集仕様

### その他
- [web.php](screens/web.php) - ルーティング定義（参考）

## devops/ - 開発環境・運用関連

開発環境のセットアップ、デプロイ、インフラに関するドキュメント

- [dev2_env.md](devops/dev2_env.md) - dev2 開発環境の構築・運用ガイド
- [run_on_aws.md](devops/run_on_aws.md) - AWS環境でのセットアップ手順

## history/ - 進捗・経緯のメモ

開発の進捗状況、変更履歴、議事録など

- [expense_form_progress.md](history/expense_form_progress.md) - 経費フォーム開発の進捗記録

---

## ドキュメント更新ルール

- 新しい画面を追加した場合は、screens/ に仕様書を追加し、このREADMEも更新する
- システム要件やデータモデルの変更があった場合は、domain/ 配下のドキュメントを更新する
- 開発環境やデプロイ手順に変更があった場合は、devops/ 配下のドキュメントを更新する
