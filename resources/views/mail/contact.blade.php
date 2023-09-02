以下のお問い合わせを受け付けました。<br>
<br>
名前： {{ $params['name'] }}<br>
メールアドレス： {{ $params['email'] }}<br>
お問い合わせ内容：<br>
{!! nl2br(e($params['body'])) !!}
