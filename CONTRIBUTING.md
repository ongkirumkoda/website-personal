# Contributing to SIRAGA

Thank you for considering contributing to SIRAGA! We welcome contributions from the community.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Reporting Bugs](#reporting-bugs)
- [Suggesting Features](#suggesting-features)

---

## Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

### Our Standards

- Be respectful and inclusive
- Welcome newcomers and help them learn
- Focus on what is best for the community
- Show empathy towards other community members

---

## How Can I Contribute?

### 1. Reporting Bugs

Before creating bug reports, please check existing issues to avoid duplicates.

**How to Submit a Bug Report:**

- Use GitHub Issues
- Use a clear and descriptive title
- Describe the steps to reproduce the issue
- Provide specific examples
- Describe the behavior you observed
- Explain what behavior you expected
- Include screenshots if applicable
- Note your environment (OS, PHP version, etc.)

### 2. Suggesting Features

Feature suggestions are welcome! Please:

- Use GitHub Issues with the "enhancement" label
- Provide a clear description of the feature
- Explain why this feature would be useful
- Provide examples of how it would work

### 3. Code Contributions

We love pull requests! Here's how to contribute code:

---

## Development Setup

### Prerequisites

- PHP 7.4+
- MySQL 5.7+
- Composer
- Git

### Setup Steps

1. **Fork the repository**
   ```bash
   # Click the "Fork" button on GitHub
   ```

2. **Clone your fork**
   ```bash
   git clone https://github.com/YOUR_USERNAME/siraga.git
   cd siraga
   ```

3. **Add upstream remote**
   ```bash
   git remote add upstream https://github.com/original/siraga.git
   ```

4. **Install dependencies**
   ```bash
   composer install
   ```

5. **Setup environment**
   ```bash
   cp .env.example .env
   # Edit .env with your configuration
   ```

6. **Run migrations**
   ```bash
   php database/migrations/migrate.php
   ```

7. **Create a branch**
   ```bash
   git checkout -b feature/my-new-feature
   ```

---

## Coding Standards

### PHP Standards

We follow PSR-12 coding standard:

**Example:**
```php
<?php

namespace Siraga\Controllers;

class ExampleController extends Controller
{
    private $model;
    
    public function __construct()
    {
        $this->model = new ExampleModel();
    }
    
    public function index()
    {
        $data = $this->model->all();
        $this->view('example/index', compact('data'));
    }
}
```

### Key Points

- Use 4 spaces for indentation (not tabs)
- Opening braces `{` on the same line for methods
- One blank line between methods
- Use meaningful variable and function names
- Add PHPDoc comments for classes and methods
- Keep functions small and focused
- Follow SOLID principles

### Database

- Use prepared statements (already implemented in Model class)
- Use meaningful table and column names
- Add indexes for frequently queried columns
- Document complex queries

### Frontend

- Use Bootstrap 5 classes for consistency
- Keep CSS organized and commented
- Use semantic HTML5 tags
- Ensure responsive design
- Add accessibility features (alt tags, ARIA labels)

### JavaScript

- Use modern ES6+ syntax when possible
- Keep functions pure and modular
- Add comments for complex logic
- Handle errors gracefully

---

## Commit Guidelines

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- **feat**: New feature
- **fix**: Bug fix
- **docs**: Documentation changes
- **style**: Code style changes (formatting, etc.)
- **refactor**: Code refactoring
- **perf**: Performance improvements
- **test**: Adding tests
- **chore**: Maintenance tasks

### Examples

```bash
feat(auth): add Google OAuth integration

- Implement GoogleOAuthService
- Add OAuth callback route
- Update login view with Google button

Closes #123
```

```bash
fix(measurements): correct BMI calculation

BMI was calculated incorrectly for children under 2 years.
Updated formula and added validation.

Fixes #456
```

### Rules

- Use present tense ("add feature" not "added feature")
- Use imperative mood ("move cursor to..." not "moves cursor to...")
- First line should be 50 characters or less
- Reference issues and pull requests after the first line
- Use the body to explain what and why, not how

---

## Pull Request Process

### Before Submitting

1. **Update your branch**
   ```bash
   git fetch upstream
   git rebase upstream/main
   ```

2. **Test your changes**
   - Test manually in browser
   - Check for PHP errors
   - Verify database operations
   - Test on different screen sizes

3. **Review your changes**
   ```bash
   git diff
   ```

4. **Ensure code quality**
   - Follow coding standards
   - Add comments where needed
   - Remove console.log and debug code
   - Update documentation if needed

### Submitting Pull Request

1. **Push to your fork**
   ```bash
   git push origin feature/my-new-feature
   ```

2. **Create Pull Request on GitHub**
   - Click "New Pull Request"
   - Select your branch
   - Fill in the PR template

3. **PR Template**
   ```markdown
   ## Description
   Brief description of changes
   
   ## Type of Change
   - [ ] Bug fix
   - [ ] New feature
   - [ ] Documentation update
   - [ ] Code refactoring
   
   ## Testing
   Describe how you tested this
   
   ## Screenshots (if applicable)
   Add screenshots
   
   ## Checklist
   - [ ] Code follows style guidelines
   - [ ] Self-review completed
   - [ ] Comments added to complex code
   - [ ] Documentation updated
   - [ ] No new warnings generated
   - [ ] Tests pass locally
   
   ## Related Issues
   Closes #123
   ```

### After Submitting

- Respond to feedback promptly
- Make requested changes
- Push updates to the same branch
- Be patient and respectful

### PR Review Process

1. Automated checks run
2. Code review by maintainers
3. Feedback and requested changes
4. Approval
5. Merge into main branch

---

## Reporting Bugs

### Before Reporting

- Check if the bug has already been reported
- Try to reproduce the bug
- Collect relevant information

### Bug Report Template

```markdown
## Bug Description
A clear description of the bug

## Steps to Reproduce
1. Go to '...'
2. Click on '...'
3. Scroll down to '...'
4. See error

## Expected Behavior
What you expected to happen

## Actual Behavior
What actually happened

## Screenshots
If applicable, add screenshots

## Environment
- OS: [e.g., Windows 10, Ubuntu 20.04]
- Browser: [e.g., Chrome 96, Firefox 95]
- PHP Version: [e.g., 7.4.3]
- MySQL Version: [e.g., 5.7.36]

## Additional Context
Add any other context about the problem
```

---

## Suggesting Features

### Feature Request Template

```markdown
## Feature Description
Clear description of the feature

## Problem It Solves
What problem does this feature solve?

## Proposed Solution
How do you envision this working?

## Alternatives Considered
What alternatives have you considered?

## Additional Context
Add any other context or screenshots
```

---

## Development Workflow

### Branching Strategy

- `main` - Production-ready code
- `develop` - Integration branch
- `feature/*` - New features
- `bugfix/*` - Bug fixes
- `hotfix/*` - Urgent production fixes

### Workflow

1. Create feature branch from `develop`
2. Make changes
3. Submit PR to `develop`
4. After review, merge to `develop`
5. Periodically merge `develop` to `main`

---

## Testing

### Manual Testing

Before submitting PR, test:

- All affected functionality
- Different user roles
- Different screen sizes
- Error handling
- Edge cases

### Test Checklist

- [ ] Feature works as expected
- [ ] No PHP errors or warnings
- [ ] No JavaScript console errors
- [ ] Database queries execute correctly
- [ ] Forms validate properly
- [ ] Responsive on mobile
- [ ] Works in Chrome, Firefox, Safari
- [ ] No security vulnerabilities introduced

---

## Documentation

When adding new features, update:

- `README.md` - If it affects setup or usage
- `API_DOCUMENTATION.md` - If it adds/changes API
- Inline code comments
- PHPDoc comments

---

## Questions?

If you have questions:

- Check existing documentation
- Search GitHub issues
- Ask in discussions
- Email: dev@siraga.com

---

## Recognition

Contributors will be:

- Listed in CONTRIBUTORS.md
- Mentioned in release notes
- Acknowledged in the project

Thank you for contributing to SIRAGA! 🎉

---

**Remember: Good contributions make great software!**
