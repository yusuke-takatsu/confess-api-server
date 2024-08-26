## confess

ShareMoneyのAPIサーバーのリポジトリです。

## 環境

- PHP8.2
- Laravel 10

## 環境構築

下記の流れに従って、環境構築を行なってください。

#### clone

```
git clone git@github.com:yusuke-takatsu/confess.git
```

#### build
```
docker compose build
```

#### コンテナ作成
```
docker compose up -d
```

#### Laravelコンテナへの接続
```
docker compose exec -it app bin/bash
```


※準備中