-- CREATE DATABASE placement_management;
USE placement_management;

-- CREATE TABLE students (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(100),
--     email VARCHAR(100) UNIQUE,
--     roll_no VARCHAR(20),
--     dob DATE,
--     password VARCHAR(255),
--     profile_details TEXT
-- );

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    roll_no VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    dob DATE NOT NULL,
    mobile_no VARCHAR(15) NOT NULL,
    password VARCHAR(255),
    address TEXT,
    class_10_school VARCHAR(100),
    class_10_board VARCHAR(50),
    class_10_marks FLOAT,
    class_10_year INT,                  -- Added passing year for Class 10
    class_12_school VARCHAR(100),
    class_12_board VARCHAR(50),
    class_12_marks FLOAT,
    class_12_year INT,                  -- Added passing year for Class 12
    ug_college VARCHAR(100),
    ug_university VARCHAR(100),
    ug_degree VARCHAR(50),
    ug_specialization VARCHAR(100),
    ug_marks FLOAT,
    ug_year INT,                        -- Added passing year for UG
    pg_college VARCHAR(100),
    pg_university VARCHAR(100),
    pg_degree VARCHAR(50),
    pg_specialization VARCHAR(100),
    pg_marks FLOAT,
    pg_year INT,                        -- Added passing year for PG
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    profile_picture VARCHAR(255) NULL
);



CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    profile_picture VARCHAR(255) NULL
);

CREATE TABLE IF NOT EXISTS placement_drives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100),
    job_role VARCHAR(100),
    eligibility_criteria TEXT,
    apply_deadline DATE,
    is_cancelled BOOLEAN DEFAULT 0
);

CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    drive_id INT,
    apply_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Applied', 'Selected', 'Rejected') DEFAULT 'Applied',
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (drive_id) REFERENCES placement_drives(id)
);

CREATE TABLE IF NOT EXISTS issues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    issue_text TEXT NOT NULL,
    status ENUM('pending', 'resolved', 'withdrawn') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    resolved_at DATETIME NULL,
    admin_response TEXT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY ,
    admin_id INT NOT NULL,
    recipient_id INT NULL, -- NULL means broadcast to all students
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin(id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES students(id) ON DELETE CASCADE
);


-- INSERT INTO admin (email, password) VALUES ('admin@example.com', 'your_hashed_password');


-- Insert sample data into placement_drives table
INSERT INTO placement_drives (company_name, job_role, eligibility_criteria, apply_deadline) VALUES
('Tech Solutions Inc.', 'Software Engineer', 'B.Tech in Computer Science, 7.0+ CGPA', '2024-12-15'),
('Innovative Designs Ltd.', 'UI/UX Designer', 'Any Graduate with Design Experience', '2024-11-20'),
('Data Analytics Corp.', 'Data Analyst', 'B.Sc. in Mathematics or Statistics, 6.5+ CGPA', '2024-12-01'),
('Finance Edge Pvt. Ltd.', 'Financial Analyst', 'MBA in Finance, 7.5+ CGPA', '2024-12-25'),
('Green Energy Ltd.', 'Environmental Scientist', 'M.Sc. in Environmental Science, 7.0+ CGPA', '2024-11-30'),
('HealthTech Solutions', 'Bioinformatics Engineer', 'M.Sc. in Bioinformatics, 6.0+ CGPA', '2024-11-15'),
('NextGen Robotics', 'Mechanical Engineer', 'B.Tech in Mechanical Engineering, 7.0+ CGPA', '2024-12-10'),
('CyberSecure Systems', 'Cybersecurity Specialist', 'B.Tech in IT or CSE, 7.0+ CGPA', '2024-12-05'),
('Retail Innovators', 'Data Scientist', 'B.Sc. in Computer Science, 6.5+ CGPA', '2024-11-18'),
('Future Networks', 'Network Engineer', 'B.Tech in Electronics, 7.0+ CGPA', '2024-12-02');


-- INSERT INTO students (address, 
--     class_10_school, class_10_board, class_10_marks, 
--     class_12_school, class_12_board, class_12_marks, 
--     ug_college, ug_university, ug_degree, ug_specialization, ug_marks, 
--     pg_college, pg_university, pg_degree, pg_specialization, pg_marks
-- ) VALUES 
-- (
--     'Alice Johnson', 'R12345', 'a@a.com', '2000-05-15', '1234567890', 'password_hash_1', '123 Main St, City, Country', 
--     'Sunrise High School', 'State Board', 89.5, 
--     'National Senior Secondary School', 'CBSE', 92.3, 
--     'XYZ University', 'ABC University', 'B.Sc.', 'Computer Science', 85.2, 
--     'PQR Institute of Technology', 'DEF University', 'M.Sc.', 'Data Science', 88.4
-- ),
-- (
--     'Bob Smith', 'R67890', 'bob.smith@example.com', '1999-08-22', '0987654321', 'password_hash_2', '456 Oak St, Town, Country', 
--     'Greenwood High', 'ICSE', 91.0, 
--     'St. Thomas School', 'State Board', 88.7, 
--     'LMN College', 'GHI University', 'B.Com.', 'Finance', 79.6, 
--     'JKL Business School', 'MNO University', 'MBA', 'Marketing', 82.5
-- );



-- Update all fields for the student with id = 1
-- UPDATE students 
-- SET 
--     name = 'Alice Johnson',
--     roll_no = 'R12345',
--     email = 'alice.j@example.com',
--     dob = '1999-04-15',
--     mobile_no = '1112223333',
--     password = 'hashedpassword1',  -- Replace with hashed password if needed
--     address = '789 Maple Ave, New City, Country',
--     class_10_school = 'Greenwood High School',
--     class_10_board = 'State Board',
--     class_10_marks = 89.5,
--     class_12_school = 'Central High School',
--     class_12_board = 'National Board',
--     class_12_marks = 91.0,
--     ug_college = 'Tech University',
--     ug_university = 'Tech University',
--     ug_degree = 'B.Tech',
--     ug_specialization = 'Computer Science',
--     ug_marks = 85.0,
--     pg_college = 'Advance Institute',
--     pg_university = 'Advance Institute',
--     pg_degree = 'M.Tech',
--     pg_specialization = 'Artificial Intelligence',
--     pg_marks = 91.2
-- WHERE id = 1;

-- -- Update all fields for the student with id = 2
-- UPDATE students 
-- SET 
--     name = 'Bob Smith',
--     roll_no = 'R67890',
--     email = 'bob.s@example.com',
--     dob = '2000-08-10',
--     mobile_no = '9998887777',
--     password = 'hashedpassword2',  -- Replace with hashed password if needed
--     address = '321 Pine St, New Town, Country',
--     class_10_school = 'Riverdale High School',
--     class_10_board = 'State Board',
--     class_10_marks = 78.5,
--     class_12_school = 'West High School',
--     class_12_board = 'National Board',
--     class_12_marks = 83.0,
--     ug_college = 'Business College',
--     ug_university = 'National University',
--     ug_degree = 'B.Com',
--     ug_specialization = 'Accounting',
--     ug_marks = 80.5,
--     pg_college = 'Finance Institute',
--     pg_university = 'Finance Institute',
--     pg_degree = 'M.Com',
--     pg_specialization = 'Finance',
--     pg_marks = 84.9
-- WHERE id = 2;




-- Insert broadcast notifications (for all students)
INSERT INTO notifications (admin_id, recipient_id, subject, message) VALUES
(1, NULL, 'Welcome to Fall Semester 2024', 'Dear students, welcome to the new academic semester! We hope you have a great learning experience ahead.'),
(1, NULL, 'Campus Maintenance Notice', 'The library will be closed for maintenance this weekend (Oct 29-30). Please plan accordingly.');



-- (1, NULL, 'Upcoming Career Fair', 'Join us for the Annual Career Fair on November 15th, 2024 from 10 AM to 4 PM in the Main Auditorium.'),
-- (1, NULL, 'Holiday Schedule', 'Please note that the college will be closed for Thanksgiving break from November 23-26, 2024.'),
-- (1, NULL, 'New Library Resources', 'We have added new online research databases. Visit the library portal to access them.');

-- -- Insert personal notifications (for specific students)
INSERT INTO notifications (admin_id, recipient_id, subject, message) VALUES
(1, 1, 'Assignment Submission Reminder', 'Your project report for CS301 is due this Friday. Please ensure timely submission.'),
(1, 2, 'Meeting with Academic Advisor', 'Your academic advisor has scheduled a meeting with you on October 30th at 2 PM.'),
(1, 1, 'Course Registration Alert', 'You have not yet registered for the required core course CS401. Please register before the deadline.');



-- (1, 3, 'Scholarship Update', 'Congratulations! Your scholarship has been renewed for the next semester.'),
-- (1, 2, 'Incomplete Grade Notice', 'You have an incomplete grade in MATH201. Please contact your professor to resolve this.'),
-- (1, 1, 'Library Book Overdue', 'The book "Data Structures in Java" is overdue. Please return it to avoid late fees.'),
-- (1, 4, 'Sports Team Selection', 'Congratulations! You have been selected for the college basketball team.'),
-- (1, 3, 'Lab Equipment Access', 'Your request for special lab equipment access has been approved.'),
-- (1, 2, 'Attendance Warning', 'Your attendance in PHY202 has fallen below 75%. Please improve your attendance.'),
-- (1, 4, 'Internship Opportunity', 'Based on your profile, you might be interested in the new internship opportunity at Tech Corp.');

-- -- Insert time-sensitive notifications
INSERT INTO notifications (admin_id, recipient_id, subject, message, created_at) VALUES
(1, NULL, 'Emergency Weather Alert', 'All evening classes are cancelled today due to severe weather conditions.', NOW() - INTERVAL 2 HOUR),
(1, NULL, 'System Maintenance', 'The student portal will be down for maintenance from 2 AM to 4 AM tomorrow.', NOW() - INTERVAL 1 DAY),
(1, 1, 'Urgent: Form Submission', 'Please submit your graduation application form by end of day today.', NOW() - INTERVAL 12 HOUR);


-- (1, 3, 'Interview Schedule', 'Your interview for the research assistant position is scheduled for tomorrow at 11 AM.', NOW() - INTERVAL 6 HOUR),
-- (1, 2, 'Password Reset', 'Your account password was recently reset. If this wasn\'t you, please contact IT support immediately.', NOW() - INTERVAL 30 MINUTE);


-- ALTER TABLE admin AUTO_INCREMENT = 1;

