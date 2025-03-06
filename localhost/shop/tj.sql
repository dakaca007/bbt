-- 体检套餐表
CREATE TABLE exam_packages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 检查项目表
CREATE TABLE exam_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    item_code VARCHAR(20) NOT NULL UNIQUE,
    item_name VARCHAR(100) NOT NULL,
    normal_range TEXT,
    unit VARCHAR(20),
    is_abnormal TINYINT(1) DEFAULT 0 COMMENT '0-正常 1-异常时需医生确认'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 套餐项目关联表
CREATE TABLE exam_package_items (
    package_id INT UNSIGNED NOT NULL,
    item_id INT UNSIGNED NOT NULL,
    sort_order INT DEFAULT 0,
    PRIMARY KEY (package_id, item_id),
    FOREIGN KEY (package_id) REFERENCES exam_packages(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES exam_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 预约表
CREATE TABLE exam_appointments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    package_id INT UNSIGNED NOT NULL,
    appointment_date DATE NOT NULL,
    time_slot VARCHAR(20) NOT NULL COMMENT '如: 08:00-09:00',
    status TINYINT(1) DEFAULT 0 COMMENT '0-待确认 1-已预约 2-已完成 3-已取消',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES blog_users(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES exam_packages(id) ON DELETE CASCADE,
    INDEX idx_appointment_date (appointment_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 体检结果表
CREATE TABLE exam_results (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT UNSIGNED NOT NULL,
    item_id INT UNSIGNED NOT NULL,
    result_value VARCHAR(100) NOT NULL,
    is_normal TINYINT(1) DEFAULT 1,
    doctor_id INT UNSIGNED,
    confirmed_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (appointment_id) REFERENCES exam_appointments(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES exam_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 医生表
CREATE TABLE exam_doctors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    title VARCHAR(50) NOT NULL,
    department VARCHAR(50) NOT NULL,
    signature_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES blog_users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 体检报告表
CREATE TABLE exam_reports (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT UNSIGNED NOT NULL UNIQUE,
    summary TEXT NOT NULL,
    doctor_id INT UNSIGNED NOT NULL,
    pdf_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES exam_appointments(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES exam_doctors(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 预约时间段配置
CREATE TABLE exam_time_slots (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    max_capacity INT NOT NULL DEFAULT 30,
    is_available TINYINT(1) DEFAULT 1,
    UNIQUE KEY time_slot (start_time, end_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
