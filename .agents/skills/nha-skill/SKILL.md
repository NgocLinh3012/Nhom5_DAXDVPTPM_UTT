---
name: nha-skill
description: Analyze, implement, review, and test the exam and subject management module in the Nhom5_DAXDVPTPM_UTT PHP MVC project. Use when working on exam creation, editing, deletion, listing, filtering, subject management, question selection for exams, or CSV import/export related to exams.
---

# Nha Skill

## 1. Purpose

This Skill helps analyze, develop, review, and test the exam management and subject management modules in the Nhom5_DAXDVPTPM_UTT project.

The main goals are:
- Understand the existing project structure before making changes.
- Follow the existing PHP MVC architecture.
- Implement features according to the project's current conventions.
- Avoid unnecessary changes to other modules.
- Ensure code quality, security, and basic functionality.

## 2. Project Context

- Project: Nhom5_DAXDVPTPM_UTT.
- Repository: https://github.com/NgocLinh3012/Nhom5_DAXDVPTPM_UTT
- Architecture: PHP MVC.
- Database: MySQL.
- Runtime: Docker Compose.

Main directories:
- `Core/`: Core framework and shared components.
- `MVC/Controllers/`: Controllers.
- `MVC/Models/`: Models.
- `MVC/Views/`: Views.
- `database/`: Database scripts.
- `public/`: Public entry point and static assets.

Always inspect the actual repository before assuming a file, class, route, or database table exists.

## 3. Scope

Focus on:
- Listing exams.
- Creating, editing, and deleting exams.
- Searching and filtering exams.
- Managing subjects.
- Selecting questions for exams.
- Importing and exporting exam-related CSV data, if supported by the project.

Do not modify these areas unless explicitly requested:
- Login and authentication.
- User roles and permissions.
- Student exam-taking.
- Exam submission and grading.
- Reports and statistics.
- Other team members' modules.
- Shared framework, layout, Docker, or database structure.

## 4. Workflow Before Coding

Before making changes:

1. Check the current Git branch.
2. Run `git status`.
3. Review existing uncommitted changes.
4. Inspect the project directory.
5. Locate the relevant routes, controllers, models, views, and database tables.
6. Trace the existing request flow:

   Route → Controller → Model → Database → View.

7. Identify the exact files that need modification.
8. Explain the proposed changes before editing shared or out-of-scope files.

Never overwrite existing user changes.

## 5. Implementation Rules

- Follow existing coding conventions.
- Make the smallest changes necessary.
- Keep business logic in the appropriate MVC layer.
- Validate user input on the server.
- Use prepared statements or the project's safe database methods.
- Escape output displayed in HTML.
- Check whether records exist before updating or deleting them.
- Preserve existing functionality.
- Do not invent database fields or business rules. Verify them from the actual schema and code.

### Subject Management

Check:
- Required subject information.
- Duplicate subject codes or names according to existing rules.
- Updating a subject that does not exist.
- Deleting subjects that are referenced by exams.
- Clear success and error messages.

### Exam Management

Check:
- Required exam information.
- Duplicate exam codes if applicable.
- Valid exam duration.
- Existing subject references.
- Valid question selection.
- Whether enough questions exist for the exam.
- Existing difficulty levels and database constraints.
- Relationships with other records before deletion.
- Do not expose correct answers to students before submission.

## 6. CSV Import and Export

If CSV functionality exists or is requested:

- Inspect the existing CSV format first.
- Verify column names, encoding, and delimiter.
- Validate each imported row.
- Report errors with the corresponding row number.
- Handle duplicate records.
- Use database transactions when appropriate.
- Do not assume Excel files and CSV files are interchangeable.

## 7. Code Review

After implementation, review:

- MVC architecture.
- Input validation.
- SQL injection risks.
- XSS risks.
- Authorization requirements.
- Database relationships.
- Error handling.
- User-facing messages.
- Unrelated file modifications.

Do not claim that a feature works unless it has actually been tested.

## 8. Testing

Test relevant scenarios where possible.

### Subject Management
- Display the subject list.
- Add a valid subject.
- Reject invalid or duplicate data.
- Edit an existing subject.
- Handle a nonexistent subject.
- Delete a subject safely.

### Exam Management
- Display the exam list.
- Create an exam with valid information.
- Reject invalid information.
- Edit an existing exam.
- Search and filter exams.
- Handle invalid question selections.
- Delete an exam while preserving data integrity.

### CSV
- Import valid data.
- Reject invalid data.
- Handle duplicate records.
- Export data and verify the output.

Clearly distinguish:
- Passed.
- Failed.
- Not tested.

## 9. Git Safety

Before editing:

```bash
git status
git branch --show-current
git diff
