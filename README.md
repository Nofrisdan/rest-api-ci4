# rest-api-ci4

Membuat Rest Api Menggunakan Codeigniter 4

## Table Database

<ol>
    <li>Tb_user</li>
    <li>Tb_akses</li>
     <li>Base_kontak</li>

 </ol>

# Instalasi

```
 git clone https://github.com/Nofrisdan/rest-api-ci4.git

```

# Run

```
 # Masuk Directory
 cd rest-api-ci4

 # jalankan
 php spark serve

```

# Cara Penggunaan

## Registrasi

### url

```
 http://localhost:8080/auth/rest-api/registrasi

```

### Parameter

<ol>
    <li>nama_user</li>
     <li>email</li>
     <li>wa</li>
     <li>password</li>
</ol>

### Method

<h5>POST</h5>

## Login

### url

```
 http://localhost:8080/auth/rest-api/login

```

### Parameter

<ol>
    <li>email</li>
     <li>password</li>
</ol>

### Method

<h5>POST</h5>

## Get all kontak

```
 http://localhost:8080/rest-api/all

```

### Method

<h5>GET</h5>

## Get One Kontak

```
 http://localhost:8080/rest-api/find/id_kontak

```

### Method

<h5>GET</h5>

## Create Kontak

```
 http://localhost:8080/rest-api/create

```

### Parameter

<ol>
    <li>nama_kontak</li>
     <li>email</li>
     <li>wa</li>
</ol>

### Method

<h5>POST</h5>

## Update

```
 http://localhost:8080/rest-api/update

```

### Parameter

<ol>
    <li>id</li>
     <li>nama_kontak</li>
     <li>email</li>
     <li>wa</li>
</ol>

### Method

<h5>PUT</h5>

## Delete

```
 http://localhost:8080/rest-api/delete/id_kontak

```

### Method

<h5>DELETE</h5>
