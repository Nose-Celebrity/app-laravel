# Laravelテンプレート環境について
このディレクトリは、Laravel環境のテンプレートです。
利用の際は、以下の注意点を意識しておいてください。

## コンテナ構成

このシステムでは、以下の構成で動くようコンテナが設定されています。

* appコンテナ
  * PHPの動く部分です
* webコンテナ
  * Webサーバーの動く部分です
  * appコンテナに対するフロントエンド(リバースプロキシ)にもなっています
  * publicのディレクトリしか見えません
* dbコンテナ
  * データベース部分です(MySQL)
  * 主にappコンテナから利用されます
  * 接続情報は `env.txt` に記載されています
* phpmyadminコンテナ(データベースの管理用)
  * 開発コンテナー使用時のみ起動します
* seleniumコンテナ(テスト環境のみ)
  * 評価環境使用時のみ起動します

## 利用方法

1. リポジトリのクローン
   - このリポジトリをcloneしてください(GitHub Classroomからアサインされていればあなた用です)
2. 開発コンテナを起動する
    - vscodeにて『PHP開発環境』で起動してください
3. `.env` の作成
    - 以下の指示に従い作成しましょう
4. コマンドの実行
    - 以下のコマンド
    - composer install  (最初の一回のみで大丈夫です)
    - php artisan migrate
    - php artisan db:seed
5. DBの内容を更新時に実行してください
    - php artisan migrate:fresh --seed

### env.txtと.envの書き換え
初期状態はSQLiteベースの環境となっています。
dbコンテナ(MySQL)に繋ぐため、env.txtの内容を参考に.envを書き換えておきましょう。

```file:env.txt
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=SAMPLE
MYSQL_USER=sampleuser
MYSQL_PASSWORD=samplepass
```

```file:.env ※該当箇所のみ
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

各部を照らし合わせて書き換えましょう。
```file:.env ※該当箇所のみ
DB_CONNECTION=mysql
DB_HOST=db
# DB_PORT=3306
DB_DATABASE=SAMPLE
DB_USERNAME=sampleuser
DB_PASSWORD=samplepass
```


Laravel環境の初期設定は、授業にて説明があるので、それにしたがってください。
初期設定ができていないと、単純なPHPページは表示できるかもしれませんが、Laravelのアプリケーションは(ほぼ)動きません。

## 課題の提出方法

ローカル(開発コンテナ上)での作業が終わったら、従来通りGitHub上にPushすれば完了で、自動採点がはじまります。
ただし、GitHub Classroomの仕様上、以下の作業を事前に行わないと **自動採点ができない** ので、以下の対応を忘れずに行ってください。

### GitHub Secretsの登録

Laravelの設定上、`.env`ファイルをGitHubに送信できないようにされています。
そのため、GitHubのSecrets機能を利用して、`.env`ファイルの内容をGitHubに登録してください。

1. GitHubのリポジトリのページに移動
2. Settingsをクリック
3. Security項目の **Secrets and variables** をクリック

これで現在登録済みのSecretsが表示されます(初期状態では空っぽ)。
ここで以下の内容を登録してください(`New repository secret`ボタンから登録できます)。。

* キー名: `DOTENV`
* 値: `.env`ファイルの内容をそのまま貼り付け

この設定で保存することで、自動採点の時に、`.env`ファイルを生成します。

なお、開発コンテナ内で `gh`コマンドが有効な場合、以下の操作で現在の `.env` の内容を登録できます。

```bash
$ gh secret set DOTENV -b"$(cat .env)"
```

### 評価上の注意

* Secrets `DOTENV` を登録せずに提出した場合、自動採点ができません
  * 厳密には自動採点が動きますが、ほぼ確実に失敗します
* 遅れて`DOTENV`を登録した場合、 **コードを微妙に変えて再提出** しないと自動採点が動きません
  * Actionsページにある `Re-Run` を使ってもClassroom側には**反映されない**模様です



<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
