touch README.md
code README.md
#  Student Event Management System

A comprehensive web-based platform designed to streamline event coordination and participation within university communities. This system enables students to discover, register, and manage campus events while providing administrators with powerful tools for event management.

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

##  Features

###  For Students
- **Event Discovery**: Browse upcoming events with detailed information
- **Easy Registration**: One-click event registration system
- **Personal Dashboard**: Track registered events and participation history
- **Search Functionality**: Find events by title, description, or organizer
- **Responsive Design**: Accessible on all devices

###  For Administrators
- **Event Management**: Create, edit, and delete events with rich details
- **User Management**: Monitor student registrations and participation
- **Admin Dashboard**: Overview of events and system analytics
- **Bulk Operations**: Manage multiple events efficiently

###  Technical Features
- **Secure Authentication**: Role-based access control (Admin/Student)
- **Real-time Validation**: Live email and student ID availability checks
- **Session Management**: Secure user sessions with proper timeout handling
- **Form Validation**: Client-side and server-side validation
- **Responsive UI**: Modern glass-morphism design with smooth animations

##  Quick Start

### Prerequisites
- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB
- Web server (Apache/Nginx)

### Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/fathima-shahfa/student-event-management.git
   cd student-event-management
   ```

2. **Database Setup**
   ```sql
   -- Import the database structure
   mysql -u root -p < db_structure.sql
   ```

3. **Configuration**
   - Update database credentials in `includes/db.inc.php`
   ```php
   $conn = new mysqli("localhost", "your_username", "your_password", "event_management_system", 3307);
   ```

4. **Admin Account Setup**
   - Run `admin.php` once to create the default admin user
   - **Default Admin Credentials:**
     - Username: `Admin User`
     - Email: `admin@example.com`
     - Password: `password`
     - Student ID: `ADM001`

5. **Access the Application**
   - Navigate to `http://localhost/student-event-management`
   - Start exploring events or log in with admin credentials


## Database Schema

### Core Tables
- **users**: User accounts and profiles
- **events**: Event information and details
- **registrations**: Event participation records
- **categories**: Event classification system
- **notifications**: User notification system

### Sample Data
The system comes pre-loaded with diverse event types:
-  Workshops & Bootcamps
-  Hackathons & Tech Challenges
-  Seminars & Academic Events
-  Social & Cultural Gatherings
-  Sports Competitions
-  Environmental Initiatives

##  User Roles

### Student
- Register and manage personal account
- Browse and search events
- Register for events
- View participation history
- Receive event notifications

### Administrator
- Full event CRUD operations
- User management capabilities
- System analytics and reporting
- Event participant tracking
- Category management

##  Design & UX

- **Modern Aesthetic**: Glass-morphism design with vibrant accents
- **Intuitive Navigation**: Clear menu structure and user flows
- **Responsive Layout**: Optimized for desktop, tablet, and mobile
- **Interactive Elements**: Hover effects, animations, and real-time feedback
- **Accessibility**: High contrast ratios and keyboard navigation support

##  Security Features

- Password hashing using `password_hash()`
- SQL injection prevention with prepared statements
- XSS protection through output escaping
- Session management and validation
- Role-based access control
- Input sanitization and validation

##  Customization

### Adding New Event Types
```php
// In add_event.php and edit_events.php
<option value="your_new_type">Your Event Type</option>
```

### Modifying Styling
- Primary colors and themes in `style.css`
- Update color scheme in CSS variables section
- Modify component styles in respective sections

### Extending Functionality
- Add new database tables in `db_structure.sql`
- Create new PHP modules following existing patterns
- Extend JavaScript functionality in `script.js`

##  Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

##  Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 👨‍💻 Developer

**Fathima Shahfa** - 23IT0534  
*Information Technology Student*

## 🆘 Support

For support and questions:
-  Email: fathimashahfa03@gmail.com

---
