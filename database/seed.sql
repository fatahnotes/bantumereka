.\mysqldump : mysqldump: [Warning] Using a password on the command line 
interface can be insecure.
At line:1 char:51
+ ... inx64\bin"; .\mysqldump -u root -pPanji321 --no-create-info --complet ...
+                 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    + CategoryInfo          : NotSpecified: (mysqldump: [War...an be insecure. 
   :String) [], RemoteException
    + FullyQualifiedErrorId : NativeCommandError
 
-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: bantumereka_app
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `password`, `nama`) VALUES (1,'mimin','d6cdb1f6ee23882dc51f7f28c38af506','Administrator');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `bank`
--

LOCK TABLES `bank` WRITE;
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
INSERT INTO `bank` (`id`, `nama_bank`, `no_rekening`, `atas_nama`, `gambar_qris`) VALUES (5,'Bank BCA','286-0616-931','Fatah Yasin','');
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `distribution_activities`
--

LOCK TABLES `distribution_activities` WRITE;
/*!40000 ALTER TABLE `distribution_activities` DISABLE KEYS */;
INSERT INTO `distribution_activities` (`id`, `withdrawal_id`, `nama_kegiatan`, `keterangan`, `kategori_dist_id`, `bukti_file`, `created_at`) VALUES (5,6,'Penyaluran MBG Pada Desa Bese, Banten Part 1','Penyaluran dilakukan dengan tertib dan berhasil dengan dokumentasi di https://drive.google.com',1,'01. TTE OK ST Evaluasi ZI WBK 13-20 April 2026.pdf','2026-05-17 00:21:20'),(6,7,'Operasional Tim','Pemberian Fee Transport ke tim di lapangan lihat dokumentasi di https://drive.google.com',2,'02. TTE OK ST Evaluasi PK SPIP 19-25 April 2026.pdf','2026-05-17 00:36:04');
/*!40000 ALTER TABLE `distribution_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `distribution_recipients`
--

LOCK TABLES `distribution_recipients` WRITE;
/*!40000 ALTER TABLE `distribution_recipients` DISABLE KEYS */;
INSERT INTO `distribution_recipients` (`id`, `activity_id`, `nama`, `jumlah_diterima`, `kontak`, `alamat`, `keterangan`) VALUES (16,5,'Asmat',3000000.00,'09988111000','Bese','Ortu dari Dewi'),(17,5,'Sonson',5000000.00,'09988111003','Ario','Ortu dari Bunga'),(18,5,'Siti K',10000000.00,'09988111006','Antapura','Ortu dari Kaka'),(21,6,'Sandi Permana',1800000.00,'08665511122','Jakarta','Ongkos Tim Banten'),(22,6,'Galih',2100000.00,'08665511121','Jakarta','Ongkos TIm Serang');
/*!40000 ALTER TABLE `distribution_recipients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `donasi`
--

LOCK TABLES `donasi` WRITE;
/*!40000 ALTER TABLE `donasi` DISABLE KEYS */;
INSERT INTO `donasi` (`id`, `program_id`, `nama`, `email`, `no_hp`, `kecamatan`, `kabupaten`, `provinsi`, `jumlah`, `metode_pembayaran`, `bank_tujuan`, `status`, `midtrans_order_id`, `midtrans_token`, `created_at`) VALUES (10,66,'Fatah Yasin','fatahnotes@gmail.com','085292270326','Duren Sawit','KOTA ADM. JAKARTA TIMUR','DKI JAKARTA',7000000.00,'transfer','5','berhasil',NULL,NULL,'2026-05-17 00:03:29'),(11,66,'Sonia Harahap','senjamenantikita@gmail.com','087788111000','Muara Tembesi','KAB. BATANGHARI','JAMBI',35000000.00,'transfer','5','berhasil',NULL,NULL,'2026-05-17 00:09:08'),(12,66,'Fatah Yasin','fatahnotes@gmail.com','085292270326','Duren Sawit','KOTA ADM. JAKARTA TIMUR','DKI JAKARTA',8600000.00,'qris','5','berhasil',NULL,NULL,'2026-05-17 00:10:54'),(13,66,'Anonim','harlestsari@gmail.com','','Gresik','KAB. GRESIK','JAWA TIMUR',8300000.00,'transfer','5','pending',NULL,NULL,'2026-05-17 00:12:27'),(14,66,'Ranto Suratno','ratno@gmail.com','087666555211','Dulupi','KAB. BOALEMO','GORONTALO',3000000.00,'transfer','5','berhasil',NULL,NULL,'2026-05-17 00:14:14'),(15,66,'Purnamawati','purnamawati@kemenbud.go.id','0998877881110','Tilamuta','KAB. BOALEMO','GORONTALO',4600000.00,'transfer','5','berhasil',NULL,NULL,'2026-05-17 00:15:57'),(16,64,'Anonim','sarwoedi@gmail.com','','Soug Jaya','KAB. TELUK WONDAMA','PAPUA BARAT',50000000.00,'transfer','5','berhasil',NULL,NULL,'2026-05-17 01:02:27'),(17,74,'Fatah Yasin','fatahnotes@gmail.com','085292270326','Duren Sawit','KOTA ADM. JAKARTA TIMUR','DKI JAKARTA',7950000.00,'transfer','5','berhasil',NULL,NULL,'2026-05-17 01:36:02');
/*!40000 ALTER TABLE `donasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` (`id`, `nama`, `slug`, `created_at`) VALUES (7,'Pendidikan','pendidikan','2026-05-16 23:33:59'),(8,'Pangan & Gizi','pangan-gizi','2026-05-16 23:33:59'),(9,'Kesehatan','kesehatan','2026-05-16 23:33:59'),(10,'Bencana Alam','bencana-alam','2026-05-16 23:33:59'),(11,'Ekonomi & Pemberdayaan','ekonomi-pemberdayaan','2026-05-16 23:33:59'),(12,'Infrastruktur Sosial','infrastruktur-sosial','2026-05-16 23:33:59'),(13,'Yatim & Dhuafa','yatim-dhuafa','2026-05-16 23:33:59'),(14,'Lingkungan Hidup','lingkungan-hidup','2026-05-16 23:33:59'),(15,'Air Bersih & Sanitasi','air-bersih-sanitasi','2026-05-16 23:33:59'),(16,'Perlindungan Anak','perlindungan-anak','2026-05-16 23:33:59'),(17,'Pemberdayaan Perempuan','pemberdayaan-perempuan','2026-05-16 23:33:59'),(18,'Disabilitas','disabilitas','2026-05-16 23:33:59'),(19,'Keagamaan & Rumah Ibadah','keagamaan-rumah-ibadah','2026-05-16 23:33:59'),(20,'Kemanusiaan & Pengungsi','kemanusiaan-pengungsi','2026-05-16 23:33:59'),(21,'Teknologi & Digitalisasi','teknologi-digitalisasi','2026-05-16 23:33:59'),(22,'Konservasi Alam & Satwa','konservasi-alam-satwa','2026-05-16 23:33:59'),(23,'Seni, Budaya & Kreativitas','seni-budaya-kreativitas','2026-05-16 23:33:59'),(24,'Bantuan Hukum & Advokasi','bantuan-hukum-advokasi','2026-05-16 23:33:59'),(25,'Kesehatan Mental','kesehatan-mental','2026-05-16 23:33:59'),(26,'Kepemudaan & Olahraga','kepemudaan-olahraga','2026-05-16 23:33:59');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `kategori_penyaluran`
--

LOCK TABLES `kategori_penyaluran` WRITE;
/*!40000 ALTER TABLE `kategori_penyaluran` DISABLE KEYS */;
INSERT INTO `kategori_penyaluran` (`id`, `nama`, `slug`, `created_at`) VALUES (1,'Bantuan Langsung','bantuan-langsung','2026-05-16 13:17:25'),(2,'Operasional','operasional','2026-05-16 13:17:25'),(3,'Lainnya','lainnya','2026-05-16 13:17:25');
/*!40000 ALTER TABLE `kategori_penyaluran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `laporan_bantuan`
--

LOCK TABLES `laporan_bantuan` WRITE;
/*!40000 ALTER TABLE `laporan_bantuan` DISABLE KEYS */;
INSERT INTO `laporan_bantuan` (`id`, `nama_pelapor`, `kontak_pelapor`, `ketua_rt`, `kontak_rt`, `nama_sasaran`, `provinsi`, `kabupaten`, `kecamatan`, `kelurahan`, `alamat_detail`, `kategori_id`, `permasalahan`, `link_pendukung`, `tingkat_urgensi`, `admin_urgensi`, `admin_keterangan`, `admin_prioritas`, `admin_status`, `file_proposal`, `file_pendukung`, `status`, `created_at`) VALUES (2,'FATAH YASIN','fatahnotes@gmail.com','Timbul Prayitno','087840098900','Kaki Sanusi','BALI','KAB. BANGLI','Susut','Selat','Jalan bali bali denpasar no 45',10,'Oleh karena itu demikian sehingga dan pada akhirnya, Oleh karena itu demikian sehingga dan pada akhirnya, Oleh karena itu demikian sehingga dan pada akhirnya, Oleh karena itu demikian sehingga dan pada akhirnya, Oleh karena itu demikian sehingga dan pada akhirnya,','https://drive.google.com',5,NULL,NULL,0,'baru','1778986147_proposal.pdf','1778986147_pendukung.pdf','baru','2026-05-17 02:49:07'),(3,'FATAH YASIN','fatahnotes@gmail.com','Soni Prihantoro','087840098901','Rohanah B','MALUKU','KOTA TUAL','Tayando Tam','Tayando Langgiar','tes alamat',16,'tes permasalahan isi alasan','https://drive.google.com',5,NULL,NULL,0,'baru','1778986549_proposal.pdf','1778986549_pendukung.pdf','baru','2026-05-17 02:55:49'),(4,'FATAH YASIN','fatahnotes@gmail.com','Suroso Antonio','087840098800','Santonio Harapaa','BANTEN','KOTA CILEGON','Purwakarta','Kotabumi','tes alamat',18,'tes tes tes permasalahan dan alasan membutuhkan bantuan, tes tes tes permasalahan dan alasan membutuhkan bantuan, tes tes tes permasalahan dan alasan membutuhkan bantuan, tes tes tes permasalahan dan alasan membutuhkan bantuan, ','https://drive.google.com',9,10,'Bisa dijadikan program ',1,'approve','1778987324_proposal.pdf','1778987324_pendukung.pdf','baru','2026-05-17 03:08:44');
/*!40000 ALTER TABLE `laporan_bantuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` (`id`, `nama`, `logo`, `website_url`, `urutan`) VALUES (1,'Kementerian Sosial RI','1778992431_partner.png','https://kemensos.go.id',1),(2,'BNPB Indonesia','1778992445_partner.png','https://bnpb.go.id',2),(3,'Kitabisa.com','1778992457_partner.jpg','https://kitabisa.com',3),(4,'Ethereum Foundation','1778992472_partner.png','https://ethereum.org',4),(5,'Rumah Zakat','1778992484_partner.png','https://rumahzakat.org',5),(7,'Komunitas One Day One Juz','1778994299_partner.png','https://onedayonejuz.org',6);
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `program`
--

LOCK TABLES `program` WRITE;
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
INSERT INTO `program` (`id`, `kategori_id`, `nama`, `slug`, `deskripsi`, `detail`, `target_donasi`, `terkumpul`, `gambar`, `is_active`, `is_prioritas`, `created_at`) VALUES (64,7,'Beasiswa Pelajar Miskin Berprestasi','beasiswa-pelajar-miskin-berprestasi','Membantu siswa dan mahasiswa dari keluarga tidak mampu agar tetap bersekolah dan meraih cita-cita.','<p>Di pelosok negeri, banyak anak cerdas yang terpaksa putus sekolah karena orang tua mereka tak mampu membeli buku, seragam, atau biaya transportasi. Program Beasiswa Pelajar Miskin Berprestasi hadir untuk memastikan bahwa kemiskinan tidak menjadi penghalang bagi generasi emas Indonesia.</p>\r\n <img src=\"https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&q=80\" alt=\"Anak sekolah\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Dengan donasi Anda, kami akan menanggung biaya SPP, seragam, buku, alat tulis, dan uang transportasi bagi 500 pelajar SD hingga SMA serta 100 mahasiswa selama satu tahun ajaran. Kami juga memberikan pendampingan belajar dan motivasi dari para relawan.</p>\r\n <h4>Mengapa Ini Penting?</h4>\r\n <ul>\r\n   <li>Angka putus sekolah di Indonesia masih tinggi, terutama di daerah 3T (Terdepan, Terpencil, Tertinggal).</li>\r\n   <li>Setiap anak berhak mendapatkan pendidikan layak tanpa terkendala biaya.</li>\r\n   <li>Investasi pendidikan adalah jalan keluar dari lingkaran kemiskinan.</li>\r\n </ul>\r\n <p>Dukung program ini dan jadilah bagian dari perubahan hidup seorang anak.</p>',250000000.00,0.00,'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&q=80',1,1,'2026-05-16 23:58:12'),(66,8,'Dapur Gizi untuk Balita Stunting','dapur-gizi-balita-stunting','Menyediakan makanan bergizi setiap hari bagi balita penderita stunting di daerah rawan pangan.','<p>Indonesia masih menghadapi darurat stunting. Lebih dari 1 dari 4 balita di negeri ini mengalami gangguan pertumbuhan akibat kekurangan gizi kronis. Program Dapur Gizi hadir untuk menyelamatkan generasi penerus bangsa.</p>\r\n <img src=\"https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800&q=80\" alt=\"Anak makan bergizi\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Kami membangun dapur gizi di 5 desa dengan angka stunting tertinggi. Setiap hari, dapur ini akan menyediakan 200 porsi makanan bergizi seimbang yang dirancang oleh ahli gizi, terdiri dari karbohidrat, protein hewani, sayuran, dan buah. Selain itu, ibu-ibu hamil dan menyusui juga akan mendapatkan tambahan gizi.</p>\r\n <h4>Mengapa Harus Bertindak?</h4>\r\n <ul>\r\n   <li>Stunting menyebabkan kerusakan otak permanen yang akan mempengaruhi masa depan anak.</li>\r\n   <li>Investasi gizi adalah pondasi pembangunan sumber daya manusia Indonesia.</li>\r\n   <li>Setiap Rp 1 yang diinvestasikan dalam program gizi akan mengembalikan Rp 48 dalam bentuk produktivitas.</li>\r\n </ul>',200000000.00,0.00,'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800&q=80',1,1,'2026-05-16 23:58:12'),(67,8,'Bantuan Pangan Keluarga Buruh Harian','bantuan-pangan-keluarga-buruh-harian','Paket sembako untuk keluarga buruh harian yang kehilangan penghasilan akibat ketidakpastian ekonomi.','<p>Jutaan keluarga buruh harian di Indonesia hidup dalam ketidakpastian. Hari ini bekerja, besok belum tentu. Ketika harga pangan naik, mereka adalah yang paling terdampak. Program ini hadir untuk memastikan tidak ada keluarga yang tidur dalam kelaparan.</p>\r\n <img src=\"https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80\" alt=\"Paket sembako\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Kami mendistribusikan 1000 paket sembako setiap bulan ke keluarga buruh tani, nelayan, dan pekerja informal di 10 kabupaten. Setiap paket berisi beras, minyak goreng, telur, gula, dan bahan pokok lain yang cukup untuk memenuhi kebutuhan satu keluarga selama 2 minggu.</p>\r\n <p>Lebih dari sekadar bantuan, program ini adalah jaring pengaman sosial bagi mereka yang luput dari perhatian pemerintah.</p>',150000000.00,0.00,'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80',1,0,'2026-05-16 23:58:12'),(68,9,'Klinik Terapung untuk Pulau Terpencil','klinik-terapung-pulau-terpencil','Layanan kesehatan gratis di atas perahu bagi masyarakat pulau-pulau kecil tanpa fasilitas medis.','<p>Di Indonesia, ada ribuan pulau kecil yang penduduknya tidak pernah melihat dokter seumur hidup. Ketika sakit, mereka hanya pasrah. Program Klinik Terapung hadir untuk membawa harapan dan kesembuhan ke pelosok negeri.</p>\r\n <img src=\"https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&q=80\" alt=\"Klinik terapung\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Satu unit kapal klinik akan dioperasikan selama satu tahun, berlayar dari pulau ke pulau di wilayah Kepulauan Riau, Maluku, dan NTT. Kapal ini dilengkapi ruang periksa, obat-obatan, alat USG, dan tenaga medis relawan yang siap melayani 24 jam.</p>\r\n <h4>Layanan yang Diberikan</h4>\r\n <ul>\r\n   <li>Pemeriksaan kesehatan umum dan gigi.</li>\r\n   <li>Pelayanan ibu hamil dan imunisasi anak.</li>\r\n   <li>Pengobatan penyakit tropis seperti malaria dan cacingan.</li>\r\n   <li>Penyuluhan hidup sehat dan sanitasi.</li>\r\n </ul>',500000000.00,0.00,'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&q=80',1,1,'2026-05-16 23:58:12'),(71,11,'Pelatihan Kerja untuk Pemuda Pengangguran','pelatihan-kerja-pemuda-pengangguran','Kursus keterampilan gratis bagi pemuda putus sekolah agar siap kerja di industri.','<p>Jutaan pemuda Indonesia menganggur karena tidak memiliki keterampilan yang dibutuhkan pasar kerja. Program ini menjembatani kesenjangan antara dunia pendidikan dan dunia industri.</p>\r\n <img src=\"https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80\" alt=\"Pelatihan kerja\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Kami membuka 5 balai latihan kerja di kota-kota dengan angka pengangguran tertinggi. Pelatihan yang ditawarkan meliputi: las listrik, menjahit, barista, digital marketing, dan coding dasar. Setiap peserta yang lulus akan disalurkan magang ke perusahaan mitra dan mendapatkan sertifikat.</p>\r\n <p>Keterampilan adalah kunci. Beri pemuda harapan, bukan belas kasihan.</p>',200000000.00,0.00,'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80',1,0,'2026-05-16 23:58:12'),(72,20,'Tenda Darurat untuk Korban Bencana','tenda-darurat-korban-bencana','Penyediaan tempat tinggal sementara yang layak bagi keluarga yang rumahnya hancur akibat bencana alam.','<p>Indonesia adalah negeri yang rawan bencana. Gempa, tsunami, banjir, dan tanah longsor terus berulang, merenggut tempat tinggal dan harapan ribuan keluarga. Dalam situasi darurat, kebutuhan paling mendesak adalah tempat berlindung.</p>\r\n <img src=\"https://images.pexels.com/photos/6995204/pexels-photo-6995204.jpeg?w=800&q=80\" alt=\"Tenda darurat\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Program Tenda Darurat menyediakan 500 unit tenda keluarga yang tahan cuaca, lengkap dengan matras, selimut, dan lampu tenaga surya. Tenda-tenda ini akan didistribusikan dalam waktu 24 jam setelah bencana terjadi. Kami bekerja sama dengan BPBD dan relawan lokal untuk memastikan bantuan sampai tepat sasaran.</p>\r\n <p>Kehadiran Anda adalah secercah cahaya di tengah gelapnya bencana.</p>',400000000.00,0.00,'https://images.pexels.com/photos/6995204/pexels-photo-6995204.jpeg?w=800&q=80',1,1,'2026-05-16 23:58:12'),(73,20,'Dapur Darurat untuk Pengungsi','dapur-darurat-untuk-pengungsi','Menyediakan ribuan porsi makanan siap saji setiap hari bagi pengungsi korban bencana.','<p>Saat bencana melanda, dapur keluarga hancur, stok makanan lenyap, dan rasa lapar menjadi ancaman kedua setelah bencana itu sendiri. Dapur Darurat hadir untuk memenuhi kebutuhan pangan ribuan pengungsi.</p>\r\n <img src=\"https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=800&q=80\" alt=\"Dapur darurat\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Satu unit dapur lapangan mampu memproduksi 2000 porsi makanan per hari, dioperasikan oleh relawan terlatih dan ahli gizi. Menu disesuaikan dengan kearifan lokal dan kebutuhan nutrisi. Dapur ini dapat didirikan dalam hitungan jam setelah bencana.</p>\r\n <p>Makanan adalah hak asasi. Dalam situasi darurat, kami hadir untuk memenuhinya.</p>',350000000.00,0.00,'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=800&q=80',1,0,'2026-05-16 23:58:12'),(74,13,'Santunan Bulanan Anak Yatim','santunan-bulanan-anak-yatim','Bantuan biaya hidup bulanan untuk anak yatim dari keluarga dhuafa.','<p>Kehilangan orang tua adalah luka yang mendalam. Namun, bagi anak yatim dari keluarga miskin, kehilangan itu juga berarti kehilangan masa depan. Program ini hadir untuk memastikan mereka tetap bisa hidup layak dan bersekolah.</p>\r\n <img src=\"https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&q=80\" alt=\"Anak yatim\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Kami memberikan santunan bulanan sebesar Rp 300.000 kepada 300 anak yatim di 15 panti asuhan dan keluarga asuh. Santunan ini digunakan untuk biaya makan, sekolah, dan kebutuhan dasar lainnya. Kami juga mengadakan program pendampingan psikososial dan kegiatan bermain setiap bulan.</p>\r\n <p>Menjadi ayah dan ibu bagi mereka yang telah kehilangan adalah panggilan kemanusiaan yang mulia.</p>',360000000.00,0.00,'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&q=80',1,1,'2026-05-16 23:58:12'),(75,13,'Paket Lebaran untuk Keluarga Dhuafa','paket-lebaran-keluarga-dhuafa','Membawa kebahagiaan Idul Fitri bagi keluarga miskin dengan paket sembako dan bingkisan.','<p>Lebaran seharusnya menjadi hari kemenangan dan kebahagiaan. Namun, bagi jutaan keluarga dhuafa, hari raya justru mengingatkan betapa sulitnya hidup. Program ini hadir untuk berbagi kebahagiaan.</p>\r\n <img src=\"https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=800&q=80\" alt=\"Paket lebaran\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Setiap tahun menjelang Idul Fitri, kami mendistribusikan 2000 paket lebaran yang berisi beras, minyak, gula, sirup, kue kering, dan baju baru untuk anak-anak. Paket ini akan diantar langsung ke rumah-rumah dhuafa di 10 kota.</p>\r\n <p>Kebahagiaan mereka adalah kebahagiaan kita semua.</p>',100000000.00,0.00,'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=800&q=80',1,0,'2026-05-16 23:58:12'),(76,18,'Kursi Roda untuk Penyandang Disabilitas','kursi-roda-penyandang-disabilitas','Donasi kursi roda bagi penyandang disabilitas yang tidak mampu.','<p>Di Indonesia, banyak penyandang disabilitas yang tidak mampu membeli alat bantu. Mereka terpaksa merangkak, digendong, atau terkurung di rumah sepanjang hidup. Satu kursi roda bisa mengubah hidup mereka secara drastis.</p>\r\n <img src=\"https://images.unsplash.com/photo-1573497620053-ea5300f94f21?w=800&q=80\" alt=\"Kursi roda\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Program ini akan mendistribusikan 300 kursi roda ke penyandang disabilitas di seluruh Indonesia. Setiap kursi roda disesuaikan dengan kebutuhan penerima. Kami juga memberikan pelatihan penggunaan dan perawatan kursi roda.</p>\r\n <p>Sebuah kursi roda bukan sekadar alat, melainkan sayap yang memberi kebebasan.</p>',150000000.00,0.00,'https://images.unsplash.com/photo-1573497620053-ea5300f94f21?w=800&q=80',1,0,'2026-05-16 23:58:12'),(77,18,'Sekolah Inklusif untuk Anak Difabel','sekolah-inklusif-anak-difabel','Mendirikan sekolah ramah difabel yang memberikan pendidikan setara.','<p>Anak-anak difabel seringkali ditolak oleh sekolah reguler. Mereka dianggap tidak mampu belajar seperti anak normal. Padahal, mereka hanya butuh metode yang berbeda dan lingkungan yang mendukung.</p>\r\n <img src=\"https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800&q=80\" alt=\"Sekolah inklusif\" style=\"width:100%; border-radius:12px; margin:15px 0;\">\r\n <p>Kami akan merenovasi 3 sekolah dasar menjadi sekolah inklusif yang dilengkapi dengan ramp, toilet khusus, alat bantu belajar, dan guru yang terlatih dalam pendidikan inklusif. Target kami: 150 anak difabel dapat bersekolah dengan layak.</p>\r\n <p>Setiap anak berhak belajar, tanpa terkecuali.</p>',250000000.00,0.00,'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800&q=80',1,0,'2026-05-16 23:58:12');
/*!40000 ALTER TABLE `program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `relawan`
--

LOCK TABLES `relawan` WRITE;
/*!40000 ALTER TABLE `relawan` DISABLE KEYS */;
INSERT INTO `relawan` (`id`, `nama_lengkap`, `email`, `no_hp`, `bulan_tahun_lahir`, `jenis_kelamin`, `kontak_darurat`, `provinsi`, `kabupaten`, `kecamatan`, `kelurahan`, `alamat_detail`, `motivasi`, `pengalaman_relawan`, `riwayat_pekerjaan`, `keahlian`, `riwayat_kesehatan`, `hobi`, `organisasi`, `pendidikan_terakhir`, `prodi`, `foto`, `pernyataan`, `status`, `admin_catatan`, `nomor_induk`, `qr_code`, `password`, `created_at`) VALUES (4,'Anas Setiawan','anas@gmail.com','085292270327','2026-06','Perempuan','085292270326','DKI JAKARTA','KOTA ADM. JAKARTA PUSAT','Gambir','Gambir','Jl. Bangka IIIA gg mulyono\r\n12730','abc adsfadsf asdfasdfad adfafsd','abc adsfadsf asdfasdfad adfafsd','abc adsfadsf asdfasdfad adfafsd','masak','tidak ada','membaca','HMI','SD','pertanian','1779009301_relawan.jpg',1,'approve','Oke selamat begabung','0620260200001','qr_4.png',NULL,'2026-05-17 09:15:01'),(5,'Jonatan','jonatan@gmail.com','085292270326','2019-05','Perempuan','085292270326','DKI JAKARTA','KOTA ADM. JAKARTA PUSAT','Sawah Besar','Pasar Baru','Jl. Bangka IIIA gg mulyono\r\n12730','oke','oke','oke','tes','tes','oke','oke','SMP','oke','1779011541_relawan.jpg',1,'approve','oke selamat datang','0520190200001','qr_5.png',NULL,'2026-05-17 09:52:21'),(6,'Siapa','siapa@gmail.com','085292270326','2019-05','Perempuan','085292270326','DKI JAKARTA','KOTA ADM. JAKARTA UTARA','Penjaringan','Kamal Muara','Jl. Bangka IIIA gg mulyono\r\n12730','tes','tes','tes','tes','tes','tes','tes','SD','tes','1779011660_relawan.jpg',1,'approve','oke','0520190200002','qr_6.png',NULL,'2026-05-17 09:54:20'),(7,'Set Set Ok','set@gmail.com','09887788998','2026-02','Laki-laki','085292270326','DKI JAKARTA','KOTA ADM. JAKARTA PUSAT','Sawah Besar','Karang Anyar','Jl. Bangka IIIA gg mulyono\r\n12730','tes','tes','tes','tes','tes','testes','tes','SMP','tes','1779062558_relawan.png',1,'pending',NULL,NULL,NULL,NULL,'2026-05-18 00:02:38');
/*!40000 ALTER TABLE `relawan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `relawan_sosial`
--

LOCK TABLES `relawan_sosial` WRITE;
/*!40000 ALTER TABLE `relawan_sosial` DISABLE KEYS */;
INSERT INTO `relawan_sosial` (`id`, `relawan_id`, `jenis`, `url`) VALUES (11,4,'instagram','https://instagram.com/mr.fatahyasin'),(12,5,'instagram','https://instagram.com/mr.fatahyasin'),(13,6,'instagram','https://instagram.com/mr.fatahyasin'),(14,7,'instagram','https://instagram.com/mr.fatahyasin');
/*!40000 ALTER TABLE `relawan_sosial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` (`id`, `nama`, `jabatan`, `foto`, `bio`, `urutan`) VALUES (1,'Dr. Ahmad Fauzi','Founder & CEO','1778991810_tim.png','Dr. Ahmad adalah pendiri Bantu Mereka. Dengan pengalaman lebih dari 15 tahun di dunia filantropi dan teknologi blockchain, ia percaya bahwa transparansi adalah kunci membangun kepercayaan donatur.',1),(2,'Dewi Kartika, S.E.','Chief Financial Officer','1778991825_tim.png','Dewi adalah ahli keuangan dengan pengalaman 10 tahun di sektor non-profit. Ia memastikan setiap rupiah donasi dikelola secara akuntabel dan transparan.',2),(3,'Rizky Pratama, S.Kom.','Chief Technology Officer','1778991843_tim.png','Rizky adalah arsitek di balik platform blockchain Bantu Mereka. Dengan keahliannya di smart contract dan keamanan Web3, ia memastikan teknologi kami aman dan transparan.',3),(4,'Ahmad Nurhaliza, S.Sos.','Program Director','1778991862_tim.png','Siti memimpin tim program kami di lapangan. Ia telah mengelola lebih dari 50 program bantuan di seluruh Indonesia dan memastikan setiap bantuan tepat sasaran.',4);
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `whatsapp_grup`
--

LOCK TABLES `whatsapp_grup` WRITE;
/*!40000 ALTER TABLE `whatsapp_grup` DISABLE KEYS */;
INSERT INTO `whatsapp_grup` (`id`, `provinsi`, `link_whatsapp`, `created_at`) VALUES (1,'DKI Jakarta','https://chat.whatsapp.com/KCnb49aCFYP5Fj02vNDD0o','2026-05-17 09:03:38');
/*!40000 ALTER TABLE `whatsapp_grup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `withdrawals`
--

LOCK TABLES `withdrawals` WRITE;
/*!40000 ALTER TABLE `withdrawals` DISABLE KEYS */;
INSERT INTO `withdrawals` (`id`, `program_id`, `jumlah`, `tanggal`, `keterangan`, `bukti_file`, `nama`, `email`, `telp`, `foto_ktp`, `metode`, `lokasi`, `status`, `created_at`) VALUES (6,66,40000000.00,'2026-05-05','Pencairan untuk bantuan pemenuhan Gizi di Pedalaman Banten Desa Bese','Final Invoice-OJS-SEAIPC2026-IMZ.pdf','Dewi Lestari','dewilestari@gmail.com','08665522111','Screenshot 2026-05-16 100226.png','Bank','BNI Mampang','selesai','2026-05-05 00:18:27'),(7,66,5000000.00,'2026-05-17','Biaya operasional ke lapangan','','Anto Suroso','antosuroso@gmail.com','06644221113','','ATM','BNI Mampang','selesai','2026-05-17 00:34:16');
/*!40000 ALTER TABLE `withdrawals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-19 10:46:07
