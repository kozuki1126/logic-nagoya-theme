# Logic Nagoya WordPress Theme

[![CI/CD Status](https://github.com/kozuki1126/logic-nagoya-theme/workflows/WordPress%20Theme%20Quality%20Assurance/badge.svg)](https://github.com/kozuki1126/logic-nagoya-theme/actions)
[![WordPress Version](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-GPL%20v2%2B-red.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

高品質なWordPressテーマ - 名古屋のライブハウス「Logic Nagoya」専用に設計されたカスタムテーマです。フルサイト編集（FSE）対応、イベント管理、設備紹介機能を備えた現代的なデザインです。

![Logic Nagoya Theme Screenshot](screenshot.png)

## ✨ 特徴

### 🎵 ライブハウス専用機能
- **イベント管理システム** - カスタム投稿タイプでライブイベントを管理
- **設備一覧ページ** - 音響・照明設備の詳細表示
- **フロアマップ表示** - 会場レイアウトの視覚的な紹介
- **料金システム表示** - レンタル料金の透明な表示

### 🎨 現代的なデザイン
- **フルサイト編集（FSE）対応** - WordPress 6.0+の最新機能
- **ダークモダンデザイン** - ライブハウスに適した美しい暗色テーマ
- **レスポンシブデザイン** - あらゆるデバイスで最適表示
- **アクセシビリティ対応** - WCAG 2.1 AAガイドライン準拠

### ⚡ パフォーマンス最適化
- **WebP画像サポート** - 次世代画像フォーマット対応
- **遅延読み込み** - ページ読み込み速度の大幅改善
- **条件付きアセット読み込み** - 必要なページでのみCSS/JS読み込み
- **キャッシュ最適化** - Transients APIを活用したデータベース負荷軽減

### 🔒 セキュリティ強化
- **出力エスケープ** - XSS攻撃からの完全な保護
- **CSRF対策** - nonce認証による不正リクエスト防止
- **直接アクセス防止** - すべてのPHPファイルにABSPATH保護

## 📋 システム要件

### 必須要件
- **WordPress**: 6.0以上
- **PHP**: 7.4以上（8.3推奨）
- **MySQL**: 5.7以上 または MariaDB 10.2以上
- **メモリ**: 128MB以上（256MB推奨）

### 推奨環境
- **Webサーバー**: Apache 2.4+ または Nginx 1.18+
- **PHP拡張モジュール**: 
  - `gd` または `imagick` (画像処理)
  - `curl` (外部API連携)
  - `mbstring` (マルチバイト文字処理)
  - `zip` (ファイル圧縮)

## 🚀 インストール

### 方法1: ダウンロード（推奨）

1. **テーマをダウンロード**
   ```bash
   # GitHubからダウンロード
   wget https://github.com/kozuki1126/logic-nagoya-theme/archive/refs/heads/main.zip
   unzip main.zip
   ```

2. **WordPressにアップロード**
   - テーマファイルを `/wp-content/themes/logic-nagoya-theme/` にアップロード
   - WordPress管理画面 > 外観 > テーマ から「Logic Nagoya」を有効化

3. **初期設定**
   - 管理画面 > Logic Nagoya Settings で基本設定を行う

### 方法2: Git Clone（開発者向け）

```bash
cd /path/to/wordpress/wp-content/themes/
git clone https://github.com/kozuki1126/logic-nagoya-theme.git
cd logic-nagoya-theme

# 依存関係のインストール
composer install --no-dev
```

## 🔌 必須・推奨プラグイン

### 必須プラグイン
これらのプラグインがないと一部機能が正常に動作しません：

| プラグイン名 | 説明 | インストール |
|-------------|------|-------------|
| **Classic Editor** | ブロックエディタとの共存 | `wp plugin install classic-editor --activate` |

### 推奨プラグイン
以下のプラグインをインストールすると、さらに機能が向上します：

| プラグイン名 | 説明 | 用途 |
|-------------|------|------|
| **Yoast SEO** | SEO最適化 | 検索エンジン対策 |
| **WP Super Cache** | キャッシュシステム | パフォーマンス向上 |
| **Contact Form 7** | お問い合わせフォーム | 顧客からの問い合わせ |
| **WP Rocket** | 高度なキャッシュ | 更なる高速化 |
| **Smush** | 画像最適化 | ファイルサイズ削減 |
| **Wordfence Security** | セキュリティ強化 | 不正アクセス防止 |

### プラグインの一括インストール

```bash
# WP-CLIを使用した一括インストール
wp plugin install classic-editor yoast-seo wp-super-cache contact-form-7 --activate
```

## 🎛️ 基本的な使用方法

### イベント管理

1. **新しいイベントを追加**
   - 管理画面 > イベント > 新規追加
   - イベント名、日時、詳細を入力
   - アイキャッチ画像を設定

2. **イベントカテゴリを管理**
   - 管理画面 > イベント > イベントカテゴリ
   - ライブ、DJ、その他などのカテゴリを作成

### カスタマイズ

1. **サイトの基本情報**
   - 管理画面 > 設定 > 一般
   - サイトのタイトル、キャッチフレーズを設定

2. **メニューの設定**
   - 管理画面 > 外観 > メニュー
   - プライマリメニュー、フッターメニューを作成

3. **カスタマイザーでのデザイン調整**
   - 管理画面 > 外観 > カスタマイズ
   - 色、フォント、レイアウトを調整

## 🛠️ 開発環境のセットアップ

### 前提条件
- Node.js 18+
- Composer 2+
- PHP 7.4+

### 開発環境の構築

```bash
# リポジトリをクローン
git clone https://github.com/kozuki1126/logic-nagoya-theme.git
cd logic-nagoya-theme

# PHP依存関係のインストール
composer install

# Git hooksの設定（品質チェック自動化）
composer run install-hooks

# 静的解析の実行
composer run test
```

### 品質チェックコマンド

```bash
# PHP文法チェック
composer run lint

# コーディング規約チェック
composer run cs

# 自動修正
composer run cs:fix

# 静的解析
composer run stan

# 全チェック実行
composer run test
```

### ファイル構成

```
logic-nagoya-theme/
├── style.css                 # メインスタイルシート
├── functions.php             # テーマ機能
├── theme.json               # フルサイト編集設定
├── index.php                # メインテンプレート
├── header.php              # ヘッダーテンプレート
├── footer.php              # フッターテンプレート
├── inc/                    # インクルードファイル
│   ├── template-tags.php   # カスタムテンプレートタグ
│   ├── template-functions.php # テンプレート拡張機能
│   └── customizer.php      # カスタマイザー設定
├── template-parts/         # テンプレートパーツ
├── assets/                 # アセットファイル
│   ├── css/               # スタイルシート
│   ├── js/                # JavaScript
│   └── fonts/             # フォントファイル
├── languages/             # 翻訳ファイル
├── composer.json          # PHP依存関係管理
├── phpstan.neon          # 静的解析設定
└── .github/
    └── workflows/
        └── qa.yml         # CI/CDパイプライン
```

## 🎨 カスタマイズガイド

### カラーパレットの変更

`theme.json`で定義されているカラーパレット：

```json
{
  "settings": {
    "color": {
      "palette": [
        {"color": "#ff6b6b", "name": "Primary", "slug": "primary"},
        {"color": "#4ecdc4", "name": "Secondary", "slug": "secondary"},
        {"color": "#ffe66d", "name": "Accent", "slug": "accent"}
      ]
    }
  }
}
```

### カスタムCSSの追加

```css
/* 追加CSSは WordPress 管理画面 > 外観 > カスタマイズ > 追加CSS に記載 */

/* プライマリカラーをオーバーライド */
:root {
  --wp--preset--color--primary: #your-color;
}

/* カスタムボタンスタイル */
.wp-block-button__link {
  transition: all 0.3s ease;
}
```

### 子テーマの作成

長期運用する場合は子テーマの使用を推奨します：

```php
<?php
// child-theme/functions.php
function child_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );
?>
```

## 🔧 トラブルシューティング

### よくある問題と解決方法

#### 🐛 "Fatal error: functions.php"
**原因**: PHP構文エラー  
**解決**: 最新版をダウンロードしてファイルを上書き

#### 🖼️ 画像が表示されない
**原因**: WebP画像の非対応ブラウザ  
**解決**: `functions.php`のWebP設定を確認

#### ⚡ サイトの読み込みが遅い
**解決手順**:
1. キャッシュプラグインを有効化
2. 画像を最適化
3. 不要なプラグインを無効化

#### 🔐 管理画面にアクセスできない
**原因**: セキュリティプラグインの誤作動  
**解決**: FTPで該当プラグインのフォルダ名を変更

### デバッグモードの有効化

```php
// wp-config.php に追加
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## 🤝 貢献方法

### バグレポート
[GitHub Issues](https://github.com/kozuki1126/logic-nagoya-theme/issues) でバグ報告をお願いします。

### 機能リクエスト
新機能の要望は [GitHub Discussions](https://github.com/kozuki1126/logic-nagoya-theme/discussions) でご相談ください。

### プルリクエスト

1. **フォーク & クローン**
   ```bash
   git clone https://github.com/YOUR-USERNAME/logic-nagoya-theme.git
   ```

2. **機能ブランチ作成**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **品質チェック実行**
   ```bash
   composer run test
   ```

4. **プルリクエスト作成**
   - 明確な説明を記載
   - テスト結果を添付

## 📞 サポート

### コミュニティサポート
- [GitHub Discussions](https://github.com/kozuki1126/logic-nagoya-theme/discussions) - 一般的な質問・相談
- [GitHub Issues](https://github.com/kozuki1126/logic-nagoya-theme/issues) - バグ報告・機能要望

### プロフェッショナルサポート
カスタマイズやコンサルティングが必要な場合は、[Logic Nagoya](mailto:info@logicnagoya.com) まで直接お問い合わせください。

## 📚 参考リンク

### WordPress開発
- [WordPress Developer Handbook](https://developer.wordpress.org/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [Full Site Editing Guide](https://developer.wordpress.org/block-editor/getting-started/full-site-editing/)

### セキュリティ
- [WordPress Security Handbook](https://developer.wordpress.org/apis/security/)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)

## 📄 ライセンス

このテーマは [GNU General Public License v2.0](https://www.gnu.org/licenses/gpl-2.0.html) の下でライセンスされています。

### 商用利用について
- ✅ 商用サイトでの利用可能
- ✅ 改変・再配布可能
- ❌ 商用サポートは含まれません

---

## 📊 変更履歴

### v1.0.0 (2025-09-24)
- 🎉 初回リリース
- 🔒 セキュリティ強化（XSS対策、CSRF対策）
- ⚡ パフォーマンス最適化
- 🎨 theme.json最適化
- 🚀 CI/CD パイプライン導入

---

<div align="center">
  <strong>Logic Nagoya WordPress Theme</strong><br>
  Made with ❤️ for the music community<br>
  <a href="https://github.com/kozuki1126/logic-nagoya-theme">⭐ Star this project</a>
</div>
