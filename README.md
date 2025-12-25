# Force SCORM Completion Plugin

A Moodle local plugin that allows administrators to manually mark SCORM activities as complete for specific users.

## About CentricApp LTD

This plugin is developed and maintained by **CentricApp LTD**, a leading provider of educational technology solutions.

**Website:** [https://centricapp.co.il/](https://centricapp.co.il/)

CentricApp specializes in creating innovative tools and plugins for learning management systems, helping educational institutions optimize their digital learning environments.

---

## Features

- **Manual SCORM Completion**: Force mark SCORM activities as complete for individual users
- **User-friendly Interface**: Simple form-based interface for administrators
- **Course Integration**: Seamlessly works with Moodle's course structure
- **Bilingual Support**: Includes English and Hebrew language packs
- **Capability-based Access**: Secure access control for authorized users only

## Requirements

- Moodle 3.0 or higher
- SCORM module installed and enabled
- Administrator or user with `local/force_scorm:view` capability

## Installation

1. Download the plugin ZIP file or clone the repository
2. Extract the contents to your Moodle installation directory:
   ```
   /path/to/moodle/local/force_scorm/
   ```
3. Log in to your Moodle site as an administrator
4. Navigate to **Site administration → Notifications**
5. Follow the on-screen installation prompts
6. The plugin will be installed and ready to use

## Usage

### Accessing the Plugin

1. Navigate to **Site administration → Plugins → Local plugins → Force SCORM Completion**
2. Or access directly via: `https://yourmoodlesite.com/local/force_scorm/myview.php`

### Marking SCORM as Complete

1. Enter the **Course ID** of the course containing the SCORM activity
2. Enter the **SCORM ID** of the specific SCORM activity
3. Enter the **User ID** of the student
4. Click **Submit**
5. The system will mark the SCORM activity as complete for that user

### Finding IDs

- **Course ID**: Found in the URL when viewing a course (`id=` parameter)
- **SCORM ID**: Found in the SCORM activity settings or URL
- **User ID**: Found in user profile URL or user management pages

## Capabilities

The plugin defines the following capability:

- `local/force_scorm:view` - Allows users to access and use the Force SCORM completion interface

By default, this capability is granted to:
- Site administrators
- Managers

## Database Requirements

The plugin interacts with the following Moodle database tables:

- `course_modules_completion` - Stores completion records
- Uses Moodle's standard SCORM and course modules tables

## Configuration

No additional configuration is required. The plugin works out of the box after installation.

## Support

For support, feature requests, or bug reports, please contact:

**CentricApp LTD**  
Website: [https://centricapp.co.il/](https://centricapp.co.il/)

## License

Copyright © 2025 CentricApp LTD. All rights reserved.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

## Version History

- **Version 2025011300** (2025-01-13)
  - Added CentricApp LTD copyright
  - Fixed hardcoded table prefix
  - Improved code quality

- **Version 2024050700** (2024-05-07)
  - Initial release
  - Core functionality for forcing SCORM completion

## Contributing

Contributions are welcome! Please ensure your code follows Moodle coding standards and includes appropriate documentation.

---

**Developed with ❤️ by CentricApp LTD**
