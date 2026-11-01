-- Modul 5 : Database (penjualan)
-- Import lewat phpMyAdmin atau: mysql -u root < database.sql

DROP DATABASE IF EXISTS penjualan;
CREATE DATABASE penjualan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE penjualan;

-- ---------------------------------------------------------
-- STRUKTUR TABEL
-- ---------------------------------------------------------

CREATE TABLE supplier (
  id     INT(11) NOT NULL AUTO_INCREMENT,
  nama   VARCHAR(100) NOT NULL,
  telp   VARCHAR(12)  NOT NULL,
  alamat TEXT NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE barang (
  id          INT(11) NOT NULL AUTO_INCREMENT,
  kode_barang VARCHAR(10)  NOT NULL,
  nama_barang VARCHAR(100) NOT NULL,
  harga       INT(11) NOT NULL,
  stok        INT(11) NOT NULL,
  supplier_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  KEY supplier_id (supplier_id),
  CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier (id)
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
  id            VARCHAR(20)  NOT NULL,
  nama          VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp          VARCHAR(12)  NOT NULL,
  alamat        TEXT NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE transaksi (
  id              INT(11) NOT NULL AUTO_INCREMENT,
  waktu_transaksi DATE NOT NULL,
  keterangan      TEXT NOT NULL,
  total           INT(11) NOT NULL,
  pelanggan_id    VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  KEY pelanggan_id (pelanggan_id),
  CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id) REFERENCES pelanggan (id)
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
  transaksi_id INT(11) NOT NULL,
  barang_id    INT(11) NOT NULL,
  harga        INT(11) NOT NULL,
  qty          INT(11) NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  KEY barang_id (barang_id),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi (id),
  CONSTRAINT fk_detail_barang    FOREIGN KEY (barang_id)    REFERENCES barang (id)
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
  id           INT(11) NOT NULL AUTO_INCREMENT,
  waktu_bayar  DATETIME NOT NULL,
  total        INT(11) NOT NULL,
  metode       ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  KEY transaksi_id (transaksi_id),
  CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi (id)
) ENGINE=InnoDB;

CREATE TABLE user (
  id_user  TINYINT(2) NOT NULL AUTO_INCREMENT,
  username VARCHAR(30)  NOT NULL,
  password VARCHAR(35)  NOT NULL,
  nama     VARCHAR(50)  NOT NULL,
  alamat   VARCHAR(150) NOT NULL,
  hp       VARCHAR(20)  NOT NULL,
  level    TINYINT(1)   NOT NULL,
  PRIMARY KEY (id_user)
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- DATA MASTER
-- ---------------------------------------------------------

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT. Maju Bersama',      '08123456',    'Surabaya'),
('PT. Senang Sekali',     '081515563',   'Bangkalan'),
('PT. Segar Segar',       '0845454663',  'Surabaya'),
('CV. Sumber Rejeki',     '081234567890','Sidoarjo'),
('PT. Aneka Pangan',      '085712345678','Gresik'),
('CV. Mitra Tani',        '082134567890','Malang'),
('PT. Jaya Abadi',        '083156789012','Mojokerto'),
('CV. Berkah Makmur',     '087812345678','Surabaya'),
('PT. Sentosa Niaga',     '081345678901','Pasuruan'),
('CV. Cahaya Baru',       '089612345678','Lamongan');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001', 'Beras 5 kg',          65000, 100, 1),
('BRG002', 'Minyak Goreng 2 L',   38000,  80, 2),
('BRG003', 'Gula Pasir 1 kg',     16000, 120, 1),
('BRG004', 'Tepung Terigu 1 kg',  12000,  90, 3),
('BRG005', 'Telur Ayam 1 kg',     28000,  60, 4),
('BRG006', 'Kopi Bubuk 200 g',    18000,  70, 5),
('BRG007', 'Teh Celup 25 pcs',     9000, 150, 5),
('BRG008', 'Susu UHT 1 L',        17000,  95, 6),
('BRG009', 'Mi Instan Dus',      110000,  40, 7),
('BRG010', 'Sabun Mandi',          6000, 200, 8);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Budi Santoso',   'L', '081200000001', 'Jl. Merdeka No. 10, Surabaya'),
('PLG002', 'Siti Aminah',    'P', '081200000002', 'Jl. Diponegoro No. 5, Sidoarjo'),
('PLG003', 'Agus Prasetyo',  'L', '081200000003', 'Jl. Pemuda No. 21, Gresik'),
('PLG004', 'Dewi Lestari',   'P', '081200000004', 'Jl. Ahmad Yani No. 8, Surabaya'),
('PLG005', 'Rudi Hartono',   'L', '081200000005', 'Jl. Kenjeran No. 15, Surabaya'),
('PLG006', 'Rina Wulandari', 'P', '081200000006', 'Jl. Gubeng No. 3, Surabaya'),
('PLG007', 'Hendra Wijaya',  'L', '081200000007', 'Jl. Raya Darmo No. 44, Surabaya'),
('PLG008', 'Putri Ayu',      'P', '081200000008', 'Jl. Mayjen Sungkono No. 9, Surabaya'),
('PLG009', 'Eko Susilo',     'L', '081200000009', 'Jl. Rungkut No. 12, Sidoarjo'),
('PLG010', 'Nur Hidayah',    'P', '081200000010', 'Jl. Tunjungan No. 7, Surabaya');

INSERT INTO user (username, password, nama, alamat, hp, level) VALUES
('admin',   MD5('admin123'),   'Administrator',   'Surabaya',  '081300000001', 1),
('kasir1',  MD5('kasir123'),   'Andi Kasir',      'Surabaya',  '081300000002', 2),
('kasir2',  MD5('kasir123'),   'Bella Kasir',     'Sidoarjo',  '081300000003', 2),
('kasir3',  MD5('kasir123'),   'Candra Kasir',    'Gresik',    '081300000004', 2),
('gudang1', MD5('gudang123'),  'Dimas Gudang',    'Surabaya',  '081300000005', 3),
('gudang2', MD5('gudang123'),  'Evi Gudang',      'Bangkalan', '081300000006', 3),
('owner',   MD5('owner123'),   'Pemilik Toko',    'Surabaya',  '081300000007', 1),
('manajer', MD5('manajer123'), 'Fajar Manajer',   'Malang',    '081300000008', 1),
('staff1',  MD5('staff123'),   'Gita Staff',      'Surabaya',  '081300000009', 2),
('staff2',  MD5('staff123'),   'Hadi Staff',      'Mojokerto', '081300000010', 2);

-- ---------------------------------------------------------
-- DATA TRANSAKSI (total = jumlah harga x qty pada detail)
-- ---------------------------------------------------------

INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-10-01', 'Belanja bulanan',        146000, 'PLG001'),
('2026-10-03', 'Kebutuhan dapur',         94000, 'PLG002'),
('2026-10-05', 'Stok warung',            110000, 'PLG003'),
('2026-10-07', 'Bahan kue',               68000, 'PLG004'),
('2026-10-09', 'Kopi dan teh kantor',     63000, 'PLG005'),
('2026-10-12', 'Susu anak',               68000, 'PLG006'),
('2026-10-15', 'Kebutuhan harian',        68000, 'PLG007'),
('2026-10-18', 'Belanja mingguan',        93000, 'PLG008'),
('2026-10-21', 'Persediaan rumah',        48000, 'PLG009'),
('2026-10-25', 'Stok mi instan warung',  220000, 'PLG010');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1,  65000, 2),
(1, 3,  16000, 1),
(2, 2,  38000, 1),
(2, 5,  28000, 2),
(3, 9, 110000, 1),
(4, 4,  12000, 3),
(4, 3,  16000, 2),
(5, 6,  18000, 2),
(5, 7,   9000, 3),
(6, 8,  17000, 4),
(7, 10,  6000, 5),
(7, 2,  38000, 1),
(8, 1,  65000, 1),
(8, 5,  28000, 1),
(9, 7,   9000, 2),
(9, 6,  18000, 1),
(9, 4,  12000, 1),
(10, 9,110000, 2);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-10-01 10:15:00', 146000, 'TUNAI',    1),
('2026-10-03 14:20:00',  94000, 'TRANSFER', 2),
('2026-10-05 09:05:00', 110000, 'EDC',      3),
('2026-10-07 16:40:00',  68000, 'TUNAI',    4),
('2026-10-09 11:30:00',  63000, 'TRANSFER', 5),
('2026-10-12 13:10:00',  68000, 'EDC',      6),
('2026-10-15 15:55:00',  68000, 'TUNAI',    7),
('2026-10-18 10:45:00',  93000, 'TRANSFER', 8),
('2026-10-21 12:25:00',  48000, 'TUNAI',    9),
('2026-10-25 17:00:00', 220000, 'EDC',     10);
