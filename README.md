# portfolio

今まで作成したサンプルサイト、およびphp学習実績の一部です。

その他社内で作ったツールもございますが、社外秘のためこちらには載せていません。
***
### サンプルサイト
- [大海大学（私立大学）](http://my.internetacademy.jp/~a31607127/academy/index.html)

![大海大学1](images/academy1.png)

![大海大学2](images/academy2.png)
<br>
- [須臾 - Shibaraku - （和カフェ）](http://my.internetacademy.jp/~a31607127/wacafe/index.html)

![大海大学1](images/wacafe1.png)

![大海大学2](images/wacafe2.png)

![大海大学3](images/wacafe3.png)
<br>
- [APRICUS TOKYO （結婚式場）](http://my.internetacademy.jp/~a31607127/wedding/index.html)
※こちらは作成途中になります

![APRICUS TOKYO1](images/wedding1.png)

![APRICUS TOKYO2](images/wedding2.png)

![APRICUS TOKYO3](images/wedding3.png)
***
### php学習ログ
- セッションを利用したログイン機能、MYSQLを利用した在庫管理機能、発注後のメール機能 等を実装しました。
- ローカルのMAMP上で動くもののため、あくまでコードのみの提示となります。
- ファイル構造は以下の通りです。
```
|--php_practice
|  |--#1
|  |  |--#1.1
|  |  |  |--admin.php
|  |  |  |--insert.php
|  |  |  |--order.php
|  |  |  |--sample.php
|  |  |  |--show_all.php
|  |  |  |--style.css
|  |  |  |--tmpl
|  |  |  |  |--admin.tmpl
|  |  |  |  |--average.tmpl
|  |  |  |  |--change.tmpl
|  |  |  |  |--data.tmpl
|  |  |  |  |--edit.tmpl
|  |  |  |  |--error.tmpl
|  |  |  |  |--insert.tmpl
|  |  |  |  |--insert_form.tmpl
|  |  |  |  |--logout.tmpl
|  |  |  |  |--order_conf.tmpl
|  |  |  |  |--order_conf_data.tmpl
|  |  |  |  |--order_form.tmpl
|  |  |  |  |--order_form_data.tmpl
|  |  |  |  |--order_send.tmpl
|  |  |  |  |--sale_all.tmpl
|  |  |  |  |--sale_data.tmpl
|  |  |  |  |--sale_date.tmpl
|  |  |  |  |--staff.tmpl
|  |  |  |  |--stock_all.tmpl
|  |  |  |  |--stock_data.tmpl
|  |  |  |  |--user_all.tmpl
|  |--DbManager.php
|  |--Encode.php
```

#### 概要
1. admin.phpをブラウザでアクセス、セッションが残っていない状態ではログイン画面となる。
![php_practice1](images/php_1/php_1-01.png)

1. IDやPASSWORDを間違えるとエラー。
![php_practice2](images/php_1/php_1-02.png)

1. ログイン後のメインメニュー。
![php_practice3](images/php_1/php_1-03.png)

1. 売上一覧メニュー。日付を選ぶとその日の売上一蘭が表示される。
![php_practice4](images/php_1/php_1-04.png)

1. また、一定期間の日当たりの平均販売数も出せる。
![php_practice5](images/php_1/php_1-05.png)

1. ユーザー一覧メニュー。DBに登録しているユーザーの情報を見れる。また、個々の購入履歴も表示できる。
![php_practice6](images/php_1/php_1-06.png)

1. 在庫一覧メニュー。DBに登録している商品の在庫数を見れる。
![php_practice7](images/php_1/php_1-07.png)

1. 商品発注メニュー。ここから商品を購入出来る。
![php_practice8](images/php_1/php_1-08.png)

1. 配送希望日を発注日から7日より前にするとエラーとなる。
![php_practice9](images/php_1/php_1-09.png)

1. 商品発注確認画面。
![php_practice10](images/php_1/php_1-10.png)

1. 発注確定後画面。
![php_practice11](images/php_1/php_1-11.png)

1. 発注確定後、メールが送られてくる。
![php_practice12](images/php_1/php_1-12.png)

1. 発注したappleの在庫が更新され、一つ減る。
![php_practice13](images/php_1/php_1-13.png)

1. yamadaの購入履歴には、appleが一つ増える。
![php_practice14](images/php_1/php_1-14.png)
