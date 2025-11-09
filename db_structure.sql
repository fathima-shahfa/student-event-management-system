-- Create database
CREATE DATABASE IF NOT EXISTS event_management_system;
USE event_management_system;

-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    contact_number VARCHAR(15),
    user_type ENUM('student', 'admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
--sample users
INSERT INTO users (name, email, password, student_id, contact_number, user_type)
VALUES ('Admin User', 'admin@example.com', 'admin123', 'ADM001', '0771234567', 'admin');


-- Events table
CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    venue VARCHAR(200) NOT NULL,
    organizer VARCHAR(100) NOT NULL,
    max_participants INT DEFAULT 100,
    event_type ENUM('workshop', 'seminar', 'hackathon', 'social', 'sports', 'academic') DEFAULT 'workshop',
    image_url VARCHAR(500),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);
--sample events
INSERT INTO events (title, description, event_date, venue, organizer, max_participants, event_type, image_url, created_by)
VALUES
('Tech Innovators Workshop', 'A hands-on session exploring emerging technologies and innovation trends.', '2025-11-15 10:00:00', 'ITUM Auditorium', 'Tech Club', 80, 'workshop', 'images/tech_innovators.avif', 1),
('AI Hackathon 2025', '24-hour hackathon focused on solving real-world problems with AI and machine learning.', '2025-12-02 09:00:00', 'Main Hall', 'Computer Society', 150, 'hackathon', 'images/ai_hackathon.jpg', 1),
('Career Guidance Seminar', 'An interactive seminar with industry professionals to guide students on career planning.', '2025-11-20 14:00:00', 'Seminar Room 3', 'Career Development Center', 100, 'seminar', 'images/career_guidance.png', 1),
('Cultural Night 2025', 'An evening filled with music, dance, and cultural performances by students.', '2025-12-10 18:00:00', 'Open Theatre', 'Student Union', 300, 'social', 'images/cultural_night.avif', 1),
('Sports Fiesta 2025', 'A week-long inter-departmental sports competition promoting teamwork and fitness.', '2025-11-25 08:00:00', 'University Grounds', 'Sports Club', 500, 'sports', 'images/sports_fiesta.webp', 1),
('Green Campus Campaign', 'A volunteer initiative to promote eco-friendly practices within the university.', '2025-11-18 09:30:00', 'Eco Park', 'Environmental Society', 120, 'academic', 'images/green_campus.jpg', 1),
('Coding Bootcamp', 'A 3-day coding bootcamp for beginners to learn the fundamentals of programming.', '2025-12-05 09:00:00', 'Lab 2', 'Coding Community', 60, 'workshop', 'images/coding_bootcamp.avif', 1),
('Web Development Bootcamp', 'A 2-day session on modern web technologies including HTML, CSS, and JavaScript.', '2025-11-22 09:00:00', 'ITUM Lab 3', 'Coding Community', 80, 'workshop', 'images/web_bootcamp.webp', 1),
('Robotics Expo 2025', 'A display of innovative student-built robots and automation systems.', '2025-11-28 10:00:00', 'Engineering Hall', 'Robotics Club', 200, 'academic', 'images/robotics_expo.jpg', 1),
('Entrepreneurship Summit', 'A conference connecting student entrepreneurs with startup mentors.', '2025-12-12 09:00:00', 'Auditorium A', 'Business Club', 250, 'seminar', 'images/entrepreneurship_summit.jpg', 1),
('Music Night', 'An evening of music performances by talented university students.', '2025-11-27 19:00:00', 'Open Grounds', 'Music Society', 300, 'social', 'images/music_night.jpg', 1),
('Innovation Challenge 2025', 'Students pitch their innovative ideas and prototypes to industry judges.', '2025-11-30 09:00:00', 'Tech Hall', 'Innovation Society', 100, 'hackathon', 'images/innovation_challenge.png', 1),
('Photography Exhibition', 'Showcase of creative student photography and digital art.', '2025-12-08 17:00:00', 'Open Theatre', 'Photography Club', 150, 'social', 'images/photography.webp', 1),
('Game Dev Workshop', 'Learn how to design and develop your own games using Unity.', '2025-03-18 09:30:00', 'Lab 4', 'Game Dev Club', 70, 'workshop', 'images/game_dev.jpg', 1),
('Science Fair 2025', 'A platform for students to present innovative science projects and research.', '2025-11-16 10:00:00', 'Science Block', 'Science Society', 200, 'academic', 'images/science_fair.webp', 1),
('Cybersecurity Awareness Day', 'Seminar and demos on protecting personal data and ethical hacking concepts.', '2025-11-23 11:00:00', 'Seminar Room 2', 'Cyber Club', 120, 'seminar', 'images/cybersecurity_day.webp', 1),
('Sports Award Ceremony', 'Recognizing athletes and winners of the annual Sports Fiesta.', '2025-12-15 16:00:00', 'Main Hall', 'Sports Club', 400, 'sports', 'images/sports.avif', 1);

-- Registrations table
CREATE TABLE registrations (
    reg_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('registered', 'attended', 'cancelled') DEFAULT 'registered',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    UNIQUE KEY unique_registration (user_id, event_id)
);

--Categories table
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);
--sample categories
INSERT INTO categories (name, description)
VALUES
('Workshops', 'Interactive sessions designed to develop practical skills and hands-on experience.'),
('Hackathons', 'Competitive programming and innovation challenges to build real-world tech solutions.'),
('Seminars', 'Educational sessions or talks conducted by experts on specific topics.'),
('Social Events', 'Gatherings and celebrations that strengthen student community and culture.'),
('Sports', 'Athletic and recreational activities promoting teamwork and physical fitness.'),
('Academic', 'Academic-focused programs and campaigns for learning and awareness.'),
('Bootcamps', 'Short, intensive training sessions focused on specific technical skills.');


--Notification table
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);