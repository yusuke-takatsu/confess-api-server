## confess

confessのAPIサーバーのリポジトリです。

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

## ER図

![confess drawio](https://github.com/user-attachments/assets/3dee18a9-c787-41ed-ae89-1615cd9b235a)