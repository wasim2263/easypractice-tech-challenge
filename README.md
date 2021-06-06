# EasyPractice Technical Challenge

Welcome to the EasyPractice tech challenge! Below you'll find a list of tasks to complete on this project. Make sure you're familiar with Git before starting. This challenge should take no more than 2 hours.

## Working on the challenge

1. Clone the repo
2. Copy `.env.example` to `.env`
3. Update the `.env` file to include the correct database connection details
4. Run `composer install`, `php artisan key:generate`, `php artisan migrate`, `npm install` and `npm run dev`
5. Open up the project in the browser and click on "Register" to create a new user. All the work will be done while logged in.
5. Work through the tasks
6. Commit as often as you like
7. Once you have completed the tasks, create a new [Pull Request](https://docs.github.com/en/github/collaborating-with-pull-requests/proposing-changes-to-your-work-with-pull-requests/creating-a-pull-request) and send us the link to it.

## The tasks

Complete as many as you can. If you feel like it, there's some BONUS tasks, but they're not required ;) 
It would be best to solve the problems in the given order, because some of these bugs might prevent you from working on the other tasks.

**Solve this first:**
- [ ] (BUG) I created some seeders that you can run with `php artisan db:seed`, but it gives an error. Can you make it work?

**And these in any order:**
- [ ] (BUG) For some reason, the client bookings are not showing up in the front-end. Can you fix that?
- [ ] (BUG) The list of bookings displayed on a client page has unformatted dates. Can you make sure they look something like this: `Monday 19 January 2020, 14:00 to 15:00`
- [ ] (FEATURE) Currently, any logged-in user can view all of the system's clients, including those created by other users. Users are obviously not happy with that. Can you make it so a single Client only belongs to one User?
- [ ] (BUG) When trying to delete a client, the front-end does not update. Can you improve the experience, so the user knows the client was actually deleted? (tip: use `php artisan db:seed --class=ClientSeeder` to generate some clients if you have none)
- [ ] (FEATURE) We noticed users started entering random data when creating clients. We should include some validation. Make sure that, when creating a client:
  - The `name` is up to 190 characters and it's required
  - The `email` is an actual valid email address
  - The `phone` can only contain digits, spaces and a plus sign
  - At least one of (phone/email) is required
- [ ] (FEATURE) The client bookings are currently displayed in random order. Please display them in chronological order, newest first.
- [ ] (FEATURE) Users want a quick way to see future and past bookings. When viewing client bookings, can you make a dropdown with three values - "All bookings", "Future bookings only" and "Past bookings only". Make it so that selecting an item from the dropdown would only show bookings that apply to the selected filter. When the page loads, default to "All bookings".

**BONUS TASKS!**
- [ ] *BONUS:* (FEATURE) Users have requested the ability to write journals for their clients. A Journal should have a date field (without hours/minutes) and a text field (unlimited length). A client can have many journals. A user should be able to view, create and delete journals.
- [ ] *BONUS:* (REFACTOR) We strive for fast and readable code that follows Laravel's/Vue.js style. Do you have any suggestions to the code quality/performance? Review the existing code and feel free to improve it any way you see fit.

## Thank You!

Thank you so much for participating in this tech challenge. Hope you had fun! If you have any suggestions, please email us at support@easypractice.net
