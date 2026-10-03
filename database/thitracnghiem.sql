-- =========================================================
-- DATABASE: thitracnghiem
-- Hệ thống thi trắc nghiệm
-- Chỉ tạo cấu trúc, không chứa dữ liệu mẫu
-- =========================================================

CREATE DATABASE IF NOT EXISTS thitracnghiem
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE thitracnghiem;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;


-- =========================================================
-- 1. BẢNG LỚP HỌC
-- =========================================================

CREATE TABLE lop_hoc (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ma_lop VARCHAR(20) NOT NULL,
    ten_lop VARCHAR(100) NOT NULL,
    trangthai TINYINT(4) DEFAULT 1,
    nguoi_tao VARCHAR(100) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY ma_lop (ma_lop)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 2. BẢNG USERS
-- Admin / Giảng viên
-- =========================================================

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    hoten VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(120) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    trangthai TINYINT(4) DEFAULT 1,
    role VARCHAR(20) DEFAULT 'admin',
    lop_id INT(11) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY username (username),
    KEY lop_id (lop_id),

    CONSTRAINT users_ibfk_1
        FOREIGN KEY (lop_id)
        REFERENCES lop_hoc(id)
        ON DELETE SET NULL

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 3. BẢNG HỌC VIÊN
-- =========================================================

CREATE TABLE hoc_vien (
    id INT(11) NOT NULL AUTO_INCREMENT,
    hoten VARCHAR(100) NOT NULL,
    ma_hv VARCHAR(50) NOT NULL,
    matkhau VARCHAR(100) NOT NULL,
    trangthai TINYINT(4) DEFAULT 1,
    lop_id INT(11) NOT NULL,
    created_by INT(11) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY ma_hv (ma_hv),
    KEY idx_hv_lop (lop_id),

    CONSTRAINT fk_hv_lop
        FOREIGN KEY (lop_id)
        REFERENCES lop_hoc(id)
        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 4. BẢNG MÔN THI
-- =========================================================

CREATE TABLE mon_thi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ma_mon VARCHAR(20) NOT NULL,
    ten_mon VARCHAR(100) NOT NULL,
    trangthai TINYINT(4) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY ten_mon (ten_mon)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 5. BẢNG CÂU HỎI
-- =========================================================

CREATE TABLE cau_hoi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    mon_id INT(11) NOT NULL,
    noi_dung VARCHAR(255) NOT NULL,

    dap_an_a VARCHAR(255) NOT NULL,
    dap_an_b VARCHAR(255) NOT NULL,
    dap_an_c VARCHAR(255) NOT NULL,
    dap_an_d VARCHAR(255) NOT NULL,

    dap_an_dung CHAR(1) NOT NULL,

    diem INT(11) DEFAULT 1,
    giai_thich TEXT DEFAULT NULL,

    loai VARCHAR(20) DEFAULT 'D',
    kich_hoat TINYINT(4) DEFAULT 1,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY idx_ch_mon (mon_id),

    CONSTRAINT fk_ch_mon
        FOREIGN KEY (mon_id)
        REFERENCES mon_thi(id)
        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 6. BẢNG ĐỀ THI
-- =========================================================

CREATE TABLE de_thi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ma_de VARCHAR(30) NOT NULL,
    ten_de VARCHAR(255) NOT NULL,
    thoi_gian INT(11) NOT NULL DEFAULT 30,
    mon_id INT(11) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY ma_de (ma_de),
    KEY mon_id (mon_id),

    CONSTRAINT de_thi_ibfk_1
        FOREIGN KEY (mon_id)
        REFERENCES mon_thi(id)
        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 7. BẢNG LIÊN KẾT ĐỀ THI - CÂU HỎI
-- =========================================================

CREATE TABLE de_thi_cau_hoi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    de_id INT(11) NOT NULL,
    cauhoi_id INT(11) NOT NULL,

    PRIMARY KEY (id),

    UNIQUE KEY uq_de_cauhoi (
        de_id,
        cauhoi_id
    ),

    KEY cauhoi_id (cauhoi_id),

    CONSTRAINT de_thi_cau_hoi_ibfk_1
        FOREIGN KEY (de_id)
        REFERENCES de_thi(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT de_thi_cau_hoi_ibfk_2
        FOREIGN KEY (cauhoi_id)
        REFERENCES cau_hoi(id)
        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 8. BẢNG PHÒNG THI
-- =========================================================

CREATE TABLE phong_thi (
    id INT(11) NOT NULL AUTO_INCREMENT,

    ma_phong VARCHAR(30) NOT NULL,
    ten_phong VARCHAR(255) NOT NULL,

    mon_id INT(11) NOT NULL,
    de_id INT(11) NOT NULL,
    lop_id INT(11) NOT NULL,

    trangthai TINYINT(4) DEFAULT 1,

    bat_dau DATETIME DEFAULT NULL,

    nguoi_tao VARCHAR(100) DEFAULT '',

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    UNIQUE KEY ma_phong (ma_phong),

    KEY mon_id (mon_id),
    KEY de_id (de_id),
    KEY lop_id (lop_id),

    CONSTRAINT phong_thi_ibfk_1
        FOREIGN KEY (mon_id)
        REFERENCES mon_thi(id),

    CONSTRAINT phong_thi_ibfk_2
        FOREIGN KEY (de_id)
        REFERENCES de_thi(id),

    CONSTRAINT phong_thi_ibfk_3
        FOREIGN KEY (lop_id)
        REFERENCES lop_hoc(id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 9. BẢNG HỌC VIÊN TRONG PHÒNG THI
-- =========================================================

CREATE TABLE phong_thi_hoc_vien (
    id INT(11) NOT NULL AUTO_INCREMENT,

    phong_id INT(11) NOT NULL,
    hocvien_id INT(11) NOT NULL,

    thoi_gian_vao DATETIME DEFAULT NULL,

    kich_hoat TINYINT(4) DEFAULT 1,

    diem INT(11) DEFAULT 0,

    cau_dung INT(11) DEFAULT 0,

    trang_thai VARCHAR(20) DEFAULT 'Chưa thi',

    lam_lai TINYINT(4) DEFAULT 0,

    so_lan_vi_pham INT(11) DEFAULT 0,

    tru INT(11) DEFAULT 0,

    con_lai INT(11) DEFAULT 0,

    ghi_chu VARCHAR(255) DEFAULT '',

    PRIMARY KEY (id),

    UNIQUE KEY uq_phong_hv (
        phong_id,
        hocvien_id
    ),

    KEY hocvien_id (hocvien_id),

    CONSTRAINT phong_thi_hoc_vien_ibfk_1
        FOREIGN KEY (phong_id)
        REFERENCES phong_thi(id)
        ON DELETE CASCADE,

    CONSTRAINT phong_thi_hoc_vien_ibfk_2
        FOREIGN KEY (hocvien_id)
        REFERENCES hoc_vien(id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 10. BẢNG BÀI LÀM
-- =========================================================

CREATE TABLE bai_lam (
    id INT(11) NOT NULL AUTO_INCREMENT,

    phong_id INT(11) NOT NULL,

    hocvien_id INT(11) NOT NULL,

    de_id INT(11) NOT NULL,

    start_at DATETIME NOT NULL,

    end_at DATETIME DEFAULT NULL,

    score FLOAT DEFAULT 0,

    correct_cnt INT(11) DEFAULT 0,

    total_cnt INT(11) DEFAULT 0,

    status VARCHAR(30) DEFAULT 'Doing',

    PRIMARY KEY (id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- 11. BẢNG CHI TIẾT BÀI LÀM
-- =========================================================

CREATE TABLE bai_lam_ct (
    id INT(11) NOT NULL AUTO_INCREMENT,

    bailam_id INT(11) NOT NULL,

    cauhoi_id INT(11) NOT NULL,

    chon CHAR(1) DEFAULT NULL,

    dung TINYINT(4) DEFAULT 0,

    diem FLOAT DEFAULT 0,

    phan_van TINYINT(4) DEFAULT 0
        COMMENT 'Danh dau phan van',

    PRIMARY KEY (id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


SET FOREIGN_KEY_CHECKS = 1;