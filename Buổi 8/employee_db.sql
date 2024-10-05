  -- phpMyAdmin SQL Dump
  -- version 4.9.0.1
  -- https://www.phpmyadmin.net/
  --
  -- Máy chủ: sql110.infinityfree.com
  -- Thời gian đã tạo: Th10 01, 2024 lúc 06:56 AM
  -- Phiên bản máy phục vụ: 10.11.9-MariaDB
  -- Phiên bản PHP: 7.2.22

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  SET AUTOCOMMIT = 0;
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Cơ sở dữ liệu: `if0_37094751_employee_db`
  --

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `departments`
  --

  CREATE TABLE `departments` (
    `department_id` int(11) NOT NULL,
    `department_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `departments`
  --

  INSERT INTO `departments` (`department_id`, `department_name`) VALUES
  (11, 'Sale'),
  (12, 'Marketing'),
  (13, 'IT');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employeeroles`
  --

  CREATE TABLE `employeeroles` (
    `role_id` int(11) NOT NULL,
    `role_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employeeroles`
  --

  INSERT INTO `employeeroles` (`role_id`, `role_name`) VALUES
  (1, 'Manager'),
  (2, 'Employee'),
  (3, 'Intern');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employees`
  --

  CREATE TABLE `employees` (
    `employee_id` int(11) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `department_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employees`
  --

  INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `department_id`, `role_id`) VALUES
  (4001, 'John1', 'Doew', 11, 1),
  (4002, 'Jane', 'Smith', 12, 2),
  (4003, 'Michael1', 'Johnson1', 11, 2),
  (4004, 'Emily', 'Williams', 12, 1),
  (4005, 'David', 'Brown', 13, 3);

  --
  -- Chỉ mục cho các bảng đã đổ
  --

  --
  -- Chỉ mục cho bảng `departments`
  --
  ALTER TABLE `departments`
    ADD PRIMARY KEY (`department_id`);

  --
  -- Chỉ mục cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    ADD PRIMARY KEY (`role_id`);

  --
  -- Chỉ mục cho bảng `employees`
  --
  ALTER TABLE `employees`
    ADD PRIMARY KEY (`employee_id`);

  --
  -- AUTO_INCREMENT cho các bảng đã đổ
  --

  --
  -- AUTO_INCREMENT cho bảng `departments`
  --
  ALTER TABLE `departments`
    MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

  --
  -- AUTO_INCREMENT cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- AUTO_INCREMENT cho bảng `employees`
  --
  ALTER TABLE `employees`
    MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4008;
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
  -- phpMyAdmin SQL Dump
  -- version 4.9.0.1
  -- https://www.phpmyadmin.net/
  --
  -- Máy chủ: sql110.infinityfree.com
  -- Thời gian đã tạo: Th10 01, 2024 lúc 06:56 AM
  -- Phiên bản máy phục vụ: 10.11.9-MariaDB
  -- Phiên bản PHP: 7.2.22

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  SET AUTOCOMMIT = 0;
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Cơ sở dữ liệu: `if0_37094751_employee_db`
  --

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `departments`
  --

  CREATE TABLE `departments` (
    `department_id` int(11) NOT NULL,
    `department_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `departments`
  --

  INSERT INTO `departments` (`department_id`, `department_name`) VALUES
  (11, 'Sale'),
  (12, 'Marketing'),
  (13, 'IT');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employeeroles`
  --

  CREATE TABLE `employeeroles` (
    `role_id` int(11) NOT NULL,
    `role_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employeeroles`
  --

  INSERT INTO `employeeroles` (`role_id`, `role_name`) VALUES
  (1, 'Manager'),
  (2, 'Employee'),
  (3, 'Intern');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employees`
  --

  CREATE TABLE `employees` (
    `employee_id` int(11) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `department_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employees`
  --

  INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `department_id`, `role_id`) VALUES
  (4001, 'John1', 'Doew', 11, 1),
  (4002, 'Jane', 'Smith', 12, 2),
  (4003, 'Michael1', 'Johnson1', 11, 2),
  (4004, 'Emily', 'Williams', 12, 1),
  (4005, 'David', 'Brown', 13, 3);

  --
  -- Chỉ mục cho các bảng đã đổ
  --

  --
  -- Chỉ mục cho bảng `departments`
  --
  ALTER TABLE `departments`
    ADD PRIMARY KEY (`department_id`);

  --
  -- Chỉ mục cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    ADD PRIMARY KEY (`role_id`);

  --
  -- Chỉ mục cho bảng `employees`
  --
  ALTER TABLE `employees`
    ADD PRIMARY KEY (`employee_id`);

  --
  -- AUTO_INCREMENT cho các bảng đã đổ
  --

  --
  -- AUTO_INCREMENT cho bảng `departments`
  --
  ALTER TABLE `departments`
    MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

  --
  -- AUTO_INCREMENT cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- AUTO_INCREMENT cho bảng `employees`
  --
  ALTER TABLE `employees`
    MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4008;
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
  -- phpMyAdmin SQL Dump
  -- version 4.9.0.1
  -- https://www.phpmyadmin.net/
  --
  -- Máy chủ: sql110.infinityfree.com
  -- Thời gian đã tạo: Th10 01, 2024 lúc 06:56 AM
  -- Phiên bản máy phục vụ: 10.11.9-MariaDB
  -- Phiên bản PHP: 7.2.22

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  SET AUTOCOMMIT = 0;
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Cơ sở dữ liệu: `if0_37094751_employee_db`
  --

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `departments`
  --

  CREATE TABLE `departments` (
    `department_id` int(11) NOT NULL,
    `department_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `departments`
  --

  INSERT INTO `departments` (`department_id`, `department_name`) VALUES
  (11, 'Sale'),
  (12, 'Marketing'),
  (13, 'IT');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employeeroles`
  --

  CREATE TABLE `employeeroles` (
    `role_id` int(11) NOT NULL,
    `role_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employeeroles`
  --

  INSERT INTO `employeeroles` (`role_id`, `role_name`) VALUES
  (1, 'Manager'),
  (2, 'Employee'),
  (3, 'Intern');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employees`
  --

  CREATE TABLE `employees` (
    `employee_id` int(11) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `department_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employees`
  --

  INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `department_id`, `role_id`) VALUES
  (4001, 'John1', 'Doew', 11, 1),
  (4002, 'Jane', 'Smith', 12, 2),
  (4003, 'Michael1', 'Johnson1', 11, 2),
  (4004, 'Emily', 'Williams', 12, 1),
  (4005, 'David', 'Brown', 13, 3);

  --
  -- Chỉ mục cho các bảng đã đổ
  --

  --
  -- Chỉ mục cho bảng `departments`
  --
  ALTER TABLE `departments`
    ADD PRIMARY KEY (`department_id`);

  --
  -- Chỉ mục cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    ADD PRIMARY KEY (`role_id`);

  --
  -- Chỉ mục cho bảng `employees`
  --
  ALTER TABLE `employees`
    ADD PRIMARY KEY (`employee_id`);

  --
  -- AUTO_INCREMENT cho các bảng đã đổ
  --

  --
  -- AUTO_INCREMENT cho bảng `departments`
  --
  ALTER TABLE `departments`
    MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

  --
  -- AUTO_INCREMENT cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- AUTO_INCREMENT cho bảng `employees`
  --
  ALTER TABLE `employees`
    MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4008;
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
  -- phpMyAdmin SQL Dump
  -- version 4.9.0.1
  -- https://www.phpmyadmin.net/
  --
  -- Máy chủ: sql110.infinityfree.com
  -- Thời gian đã tạo: Th10 01, 2024 lúc 06:56 AM
  -- Phiên bản máy phục vụ: 10.11.9-MariaDB
  -- Phiên bản PHP: 7.2.22

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  SET AUTOCOMMIT = 0;
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Cơ sở dữ liệu: `if0_37094751_employee_db`
  --

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `departments`
  --

  CREATE TABLE `departments` (
    `department_id` int(11) NOT NULL,
    `department_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `departments`
  --

  INSERT INTO `departments` (`department_id`, `department_name`) VALUES
  (11, 'Sale'),
  (12, 'Marketing'),
  (13, 'IT');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employeeroles`
  --

  CREATE TABLE `employeeroles` (
    `role_id` int(11) NOT NULL,
    `role_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employeeroles`
  --

  INSERT INTO `employeeroles` (`role_id`, `role_name`) VALUES
  (1, 'Manager'),
  (2, 'Employee'),
  (3, 'Intern');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employees`
  --

  CREATE TABLE `employees` (
    `employee_id` int(11) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `department_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employees`
  --

  INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `department_id`, `role_id`) VALUES
  (4001, 'John1', 'Doew', 11, 1),
  (4002, 'Jane', 'Smith', 12, 2),
  (4003, 'Michael1', 'Johnson1', 11, 2),
  (4004, 'Emily', 'Williams', 12, 1),
  (4005, 'David', 'Brown', 13, 3);

  --
  -- Chỉ mục cho các bảng đã đổ
  --

  --
  -- Chỉ mục cho bảng `departments`
  --
  ALTER TABLE `departments`
    ADD PRIMARY KEY (`department_id`);

  --
  -- Chỉ mục cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    ADD PRIMARY KEY (`role_id`);

  --
  -- Chỉ mục cho bảng `employees`
  --
  ALTER TABLE `employees`
    ADD PRIMARY KEY (`employee_id`);

  --
  -- AUTO_INCREMENT cho các bảng đã đổ
  --

  --
  -- AUTO_INCREMENT cho bảng `departments`
  --
  ALTER TABLE `departments`
    MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

  --
  -- AUTO_INCREMENT cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- AUTO_INCREMENT cho bảng `employees`
  --
  ALTER TABLE `employees`
    MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4008;
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
  -- phpMyAdmin SQL Dump
  -- version 4.9.0.1
  -- https://www.phpmyadmin.net/
  --
  -- Máy chủ: sql110.infinityfree.com
  -- Thời gian đã tạo: Th10 01, 2024 lúc 06:56 AM
  -- Phiên bản máy phục vụ: 10.11.9-MariaDB
  -- Phiên bản PHP: 7.2.22

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  SET AUTOCOMMIT = 0;
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Cơ sở dữ liệu: `if0_37094751_employee_db`
  --

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `departments`
  --

  CREATE TABLE `departments` (
    `department_id` int(11) NOT NULL,
    `department_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `departments`
  --

  INSERT INTO `departments` (`department_id`, `department_name`) VALUES
  (11, 'Sale'),
  (12, 'Marketing'),
  (13, 'IT');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employeeroles`
  --

  CREATE TABLE `employeeroles` (
    `role_id` int(11) NOT NULL,
    `role_name` varchar(100) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employeeroles`
  --

  INSERT INTO `employeeroles` (`role_id`, `role_name`) VALUES
  (1, 'Manager'),
  (2, 'Employee'),
  (3, 'Intern');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `employees`
  --

  CREATE TABLE `employees` (
    `employee_id` int(11) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `department_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Đang đổ dữ liệu cho bảng `employees`
  --

  INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `department_id`, `role_id`) VALUES
  (4001, 'John1', 'Doew', 11, 1),
  (4002, 'Jane', 'Smith', 12, 2),
  (4003, 'Michael1', 'Johnson1', 11, 2),
  (4004, 'Emily', 'Williams', 12, 1),
  (4005, 'David', 'Brown', 13, 3);

  --
  -- Chỉ mục cho các bảng đã đổ
  --

  --
  -- Chỉ mục cho bảng `departments`
  --
  ALTER TABLE `departments`
    ADD PRIMARY KEY (`department_id`);

  --
  -- Chỉ mục cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    ADD PRIMARY KEY (`role_id`);

  --
  -- Chỉ mục cho bảng `employees`
  --
  ALTER TABLE `employees`
    ADD PRIMARY KEY (`employee_id`);

  --
  -- AUTO_INCREMENT cho các bảng đã đổ
  --

  --
  -- AUTO_INCREMENT cho bảng `departments`
  --
  ALTER TABLE `departments`
    MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

  --
  -- AUTO_INCREMENT cho bảng `employeeroles`
  --
  ALTER TABLE `employeeroles`
    MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- AUTO_INCREMENT cho bảng `employees`
  --
  ALTER TABLE `employees`
    MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4008;
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
