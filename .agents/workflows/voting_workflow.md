---
description: how to manage candidates and verify results
---

# E-voting System Workflow

This workflow guides you through the standard operations of the E-voting system.

## 1. Candidate Management

### Adding a New Candidate
1. Log in as an **Administrator**.
2. Navigate to the **Candidates** section via the sidebar.
3. Click the **Add Candidate** button (Purple themed).
4. Upload a profile photo and enter the candidate's name, party, and description.
5. Click **Save Candidate**.

### Editing a Candidate
1. In the **Candidates** list, use the search filter to find the candidate.
2. Click the **Edit** (Pencil) icon in the actions column.
3. Update specific fields and click **Update Candidate**.

### User Management & Impersonation
1. Navigate to **User Management**.
2. From the list, you can **Add**, **Edit**, or **Delete** users.
3. **Login As Feature**: To quickly verify a voter's view, click the **Login As** (User with switch) icon in the actions column. This will automatically authenticate you as that user.
4. To return to Admin, simply **Sign Out** and log back in with admin credentials.

## 2. Voting Process (Voter Perspective)

### Casting a Vote
1. Log in as a **Voter**.
2. The dashboard will show a **Cast Vote Now** button if you haven't voted yet.
3. Browse the candidate list and click **Vote** on your preferred choice.
4. Confirm your selection in the modal.
5. You will be redirected back to the dashboard with a success message.

## 3. Real-time Results Tracking

### Monitoring Progress
1. Administrators can view the **Election Results** page for a detailed breakdown.
2. All users can see the **Analytics** section on the main dashboard for turnout rates.

// turbo
## 4. Maintenance
To refresh the search indexes or clear cache:
```powershell
php artisan view:clear
php artisan cache:clear
```
