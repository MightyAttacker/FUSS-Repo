### Deliverables
#### Usability Testing Report
- **Usability Test Plan** (300-400 words): clear objectives for the testing process.
    - Description of the test participants (recruit at least 3-4 participants).
    - List of specific tasks participants will perform, incluing tasks that utilise the backend functionality.
    - Methodology (e.g., pre-test demographics questionnaire, SUS, SEQ, think-alound protocol, observation, other post-test questionnaire).
    - Metrics for success.
- **Testing Summary and Analysis** (500-750 words): reporting of results from the testing process.
    - Summarise the process and outcomes of your usability tests.
    - Analyse the collected data, identifying key findings, common pain points, and areas of success.
    - Prioritise at least 3-5 significant usability issues to address.
- **Iteration Description** (400-500 words): description of the changes based on the usability evaluation.
    - Detail the specific changes made to the website (design, HTML, CSS, JavaScript, PHP, MySQL) based on the usability testing feedback.
    - Provide clear justification for these changes, linking them back to the identified usability issues.
- **Appendix**: should include all required materials to recreate your UX evaluation test.
    - Script
    - Survey and/or interview questions
    - Description of tasks to be completed
    - Transcript of the UX evaluators' think out loud session and any additional comments made
    - Data captured
    - Supporting observational data (screenshots, photos, ...) 

## Usability Test Plan - Jayden Putland
 The main objective for this round of usability testing was to evaluate the overall user experience of the core components of the FUSS website. Specifically, it focused upon navigation within and between pages, data input workflows and making sure key backend functions like authentication, retrival and submission of data.

 The findings will then be used to reiterate on the interface design and enhance accessibility.

 ### Participants
 Five participants were recruited for the evaluation. Each participant represented a potential end-user of the system.

 - Participant 1 - University Adult Student with advanced technical experience.
 - Participant 2 - Young University Student with moderate technical experience.
 - Participant 3 - Mature Aged Academic with limited familiarity of websites.
 - Participant 4 - University Student with above average technical experience.
 - Participant 5 - IT professional familiar with similar systems.
    
    This mix of participants while not a complete representative of all users still allowed testing with various levels of technical expertise and familarity with websites.   

### Tasks
The tasks the participants will perform are;

- Task 1: Account Creation and Login
- Task 2: Edit User Profile
- Task 3: Send a Message
- Task 4: Send a User a Skill Request

Each of these tasks were selected to reflect real-world workflows and to test the interactions between the interface and database.    

### Methodology
The methodology for the tests followed the same structure.

1. A pre-test background questionnaire to gather relevant background information and previous experience and comfortability with websites.
2. Think-aloud protocol so participants spoke through their actions and helped identify pain points during tasks. 
3. During the tasks, participant will be observed to capture hesitations and navigational errors. 
4. After each task two Single Ease Questions are asked to collect post-task ratings.
5. Finally there will be a System Usabiity Scale questionnaire to collect the post-test ratings.

### Metrics For Success

Success was measured via:
- <b>Task Completion Rate:</b> >=90% completion rate of tasks for the user without critical errors. 
- <b>Average SEQ score:</b> >= 5 on the 7-point scale.    
- <b>SUS score:</b> >= a 75 which would indicate a "good" or "B grade" system
- <b>Qualitative feedback:</b> Positive feedback towards the website, with useful feedback for improvements. 

## Testing Summary and Analysis - Lachlan Klenk
Following the usability testing plan, five participants completed a series of structured tasks on the university skill-share website. Participants ranged in age from 19–22 to 30+, and all were current university students. Each participant had varying levels of digital literacy and experience navigating online platforms. All participants were native English speakers, meaning the test did not capture accessibility or comprehension challenges that non-native speakers might encounter.

Testing was conducted through direct observation while participants completed a set of written instructions. The think-aloud protocol was used to capture users’ immediate thoughts and reactions during each task. After completing each task, participants were asked to rate the difficulty and confidence of their performance and provide verbal feedback. The aim was to identify usability issues, pain points, and successful aspects of the interface that affected the efficiency, effectiveness, and satisfaction of the user experience.

### Task 1: Account Creation and Login
Participants were first asked to create a new profile and log in. A major issue observed was that, after creating a new account, the website did not automatically redirect users to the login page. This caused confusion for most participants, with one attempting to create a second account because they were unsure whether the first registration had been successful.

Once on the login page, users reported that the process was smooth and intuitive. The inclusion of a “show password” feature was highlighted as particularly useful, as it improved user confidence and reduced login errors. Overall, this task demonstrated strong usability in the login system but revealed a critical issue in the account creation feedback process.

### Task 2: Editing User Profile
The second task required participants to edit their profile. This stage exposed several pain points. The placement of the skills and basic information section on the side of the screen made it difficult to locate, as users’ attention was primarily directed toward the main profile area. While all participants were able to complete the task, most described the process as “harder than expected.”

A notable issue was that the profile picture did not visibly update until the “Update” button was clicked. Several users assumed they had not selected the image correctly and either attempted to reselect it or forgot to save. Furthermore, when users attempted to upload a file in an unsupported format (webp), the error message was too subtle to notice. The presence of multiple save buttons for different fields also caused confusion. Participants suggested that having a single, unified save button would make the process simpler and more consistent with standard web conventions.

### Task 3: Sending a Message
The third task involved sending a message to another user. Here, participants initially struggled to identify the correct section, as the messaging feature was labelled “Inbox,” which was not immediately associated with composing new messages. Some users took several seconds to locate it. Once inside, users expressed uncertainty after sending a message due to the absence of confirmation feedback, leaving them unsure if their message was successfully delivered. Additionally, when errors occurred, messages appeared in the URL rather than on-screen, reducing clarity. Users also recommended implementing autofill suggestions for recipient names to streamline the process.

### Task 4: Sending a User Request
The final task required sending a user request. Similar to the previous task, participants suggested that autofill options for the name and skill fields would improve efficiency. The font size on the page was also criticised as too small, with one participant noting they had to “squint” to read certain elements. Another source of confusion was the naming of the “Sent Requests” and “Send Requests” pages, which were often mistaken for one another. Despite these issues, users described the calendar integration as a valuable and well-designed feature.

### Analysis and Key Findings
All five participants successfully completed each task, demonstrating that the website’s core functions are usable. However, the data revealed recurring issues related to feedback visibility, layout clarity, and terminology consistency. Users responded positively to features that supported control and transparency, such as the show-password toggle and calendar tool. In contrast, most pain points arose from unclear visual feedback and inconsistent design patterns.

The five most significant usability issues identified were:
1.	Lack of automatic redirection to the login page after account creation.
2.	Poor visual hierarchy on the edit profile page, making key sections difficult to find.
3.	Insufficient feedback for profile picture updates and error messages.
4.	Lack of system feedback and autofill in the messaging and request tasks.
5.	Small font sizes and ambiguous page labels reducing clarity.

These issues were prioritised due to their frequency across users and their potential impact on task success.




## Appendix

### Script:

Hello, thank you for participating in our website test today. We will be asking for your feedback on our Flinders University Skill Share website, this will help us improve the usability and make it more user-friendly. Please follow the instructions on the user evaluation document provided, there will be 4 tasks to complete today. As you complete each task, please remember a couple of things;

- We are not testing you, we are testing the website, there are no wrong answers, if a task confuses you or you cannot complete it, that's normal and incredibly helpful for us.

- Please speak aloud your thought processes as you use the website as this will help us know where the pain points of the website may be.


First we have a background questionnaire, then after each task we will ask you 3 questions, how easy you found the task, how confident are you that you completed the task and lastly any other comments/feedback. Finally, after completing the tasks there will be 10 questions about the system. 
We expect the process will only take 15 minutes.

Do you have any questions before we begin? All right, begin please.

### Tasks Document Given to Participants

Task 1: Create an Account and Login
1.  Locate the create an account button
2.  Create a new account with the following details
    - Email: smith@flinders.edu.au
    - First Name: Adam
    - Last Name: Smith
    - Password: Password1!
3. Return to the student login page
4. Log in to the account you just created
	
Task 2: Edit your Profile
1. Navigate to your profile
2. Locate the edit profile button
3. Change the following items
    - Profile pic to the image named Profilepic located on the desktop
    - Edit the name to Fred Flintstone
    - College to Information Technology
    - Academic Skills Offered add Basic HTML, Expert JavaScript
    - Add House Moving in Other Skills
    - Remove Basic HTML from Academic Skills
4. Go back to your profile
5. Return to the dashboard


<b><u>FLIP THE PAGE FOR THE NEXT TWO TASKS </u></b> 

Task 3: Send a Message
1. Locate the inbox
2. Send a Message;
    - To: Bob Test
    - Subject: Hello
    - Message: Hello, how are you Bob?
3. Locate the message in the outbox
4. Return to the dashboard

Task 4: Send a Request
1. Locate the Make a Request page
2. Send a request with the following details
    - To Jess Putland
    - Skill Name: Basic C++ Programming
    - Credits: 4
    - Message: I would like help with the skill above
    - Proposed Date and Time:  1st of November 2025 @ 12:15pm
3. Locate the Request in your sent requests
4. Return to the dashboard
5. Log out.



### Background Questionnaire:

1. Is English your native langauage?

2. Age Range (Under 18-18, 19-22, 23-26, 26-29, 30 and Over)

3. Gender (Woman, Man, Non-binary, Prefer to self-describe, Prefer not to say)

4. Highest level of education you have completed?

5. Current Occupation?

6. Do you currently own a laptop, desktop or both?

7. In general, do you find websites easy to use?

8. How much time do you typically spend online?

### SEQS:

1. Overall, I found the task? 1 Very Difficult 7 Easy

2. How confident are you that you completed the task successful? 1 Not Confident 7 Very Confident


### Data Captured:

#### User 1:

##### Background Questions
| Question                                                                    | Answer           |
| --------------------------------------------------------------------------- | ---------------- |
|                                                                             |                  |
| Is English your native langauage?                                           | Yes              |
|                                                                             |                  |
| Age Range (Under 18-18, 19-22, 23-26, 26-29, 30 and Over)                   | 23-26            |
|                                                                             |                  |
| Gender (Woman, Man, Non-binary, Prefer to self-describe, Prefer not to say) | Man              |
|                                                                             |                  |
| Highest level of education you have completed?                              | Advanced Diploma |
|                                                                             |                  |
| Current Occupation?                                                         | Student          |
|                                                                             |                  |
| Do you currently own a laptop, desktop or both?                             | Both             |
|                                                                             |                  |
| In general, do you find websites easy to use?                               | Yes              |
|                                                                             |                  |
| How much time do you typically spend online?                                | 17               |

##### Task Observations & Responses
| Question                                                                                       | Task 1: Create an Account and Login                                        | Task 2: Edit your Profile                      | Task 3: Send another User a message | Task 4: Send another user a request  |
| ---------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------- | ---------------------------------------------- | ----------------------------------- | ------------------------------------ |
|                                                                                                |                                                                            |                                                |                                     |                                      |
| Observations:                                                                                  | Stayed on the create account screen after account creation, realised after |                                                | Auto complete on name might be good | Again auto fill for names and skills |
| Overall, I found the task? 7 Easy 1 Very Difficult                                             | 7                                                                          | 5                                              | 7                                   | 7                                    |
| How confident are you that you completed the task successful? 1 Not Confident 7 Very Confident | 7                                                                          | 7                                              | 7                                   | 7                                    |
| Any other comments/feedback?                                                                   | Create account redirect to login                                           | skills and basic info should be seperate pages |                                     |                                      |
##### SUS score
| Question | Response | Total |
| -------- | -------- | ----- |
| 1        | 4        | 3     |
| 2        | 2        | 3     |
| 3        | 4        | 3     |
| 4        | 1        | 4     |
| 5        | 4        | 3     |
| 6        | 3        | 2     |
| 7        | 3        | 2     |
| 8        | 1        | 4     |
| 9        | 5        | 4     |
| 10       | 1        | 4     |
|          |          |       |
| Score    |          | 80    |
#### User 2:

##### Background Questions
| Question                                                                    | Answer           |
| --------------------------------------------------------------------------- | ---------------- |
|                                                                             |                  |
| Is English your native langauage?                                           | Yes              |
|                                                                             |                  |
| Age Range (Under 18-18, 19-22, 23-26, 26-29, 30 and Over)                   | 19-22            |
|                                                                             |                  |
| Gender (Woman, Man, Non-binary, Prefer to self-describe, Prefer not to say) | Man              |
|                                                                             |                  |
| Highest level of education you have completed?                              | High School      |
|                                                                             |                  |
| Current Occupation?                                                         | Student          |
|                                                                             |                  |
| Do you currently own a laptop, desktop or both?                             | Laptop           |
|                                                                             |                  |
| In general, do you find websites easy to use?                               | Most of the time |
|                                                                             |                  |
| How much time do you typically spend online?                                | 8 hrs            |

##### Task Observations & Responses
| Question                                                                                       | Task 1: Create an Account and Login | Task 2: Edit your Profile                                                                                                  | Task 3: Send another User a message                 | Task 4: Send another user a request                                       |
| ---------------------------------------------------------------------------------------------- | ----------------------------------- | -------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------- | ------------------------------------------------------------------------- |
|                                                                                                |                                     |                                                                                                                            |                                                     |                                                                           |
| Observations:                                                                                  | Show password button was useful     | The profile picture doesn't auto upload after choosing it, field reset after changing a different field, dashboard vs home | Didn't link inbox title to send a message intially, | Increase font size in message box, user was squinting at screen to read,  |
| Overall, I found the task? 7 Easy 1 Very Difficult                                             | 7                                   | 6                                                                                                                          | 7                                                   | 7                                                                         |
| How confident are you that you completed the task successful? 1 Not Confident 7 Very Confident | 7                                   | 7                                                                                                                          | 7                                                   | 7                                                                         |
| Any other comments/feedback?                                                                   | Liked the show password button      |                                                                                                                            |                                                     | Manually typin in skill is hard, maybe have an autocomplete/selection box |
##### SUS score
| Question | Response | Total |
| -------- | -------- | ----- |
| 1        | 4        | 3     |
| 2        | 2        | 3     |
| 3        | 4        | 3     |
| 4        | 1        | 4     |
| 5        | 4        | 3     |
| 6        | 1        | 4     |
| 7        | 3        | 2     |
| 8        | 2        | 3     |
| 9        | 4        | 3     |
| 10       | 1        | 4     |
|          |          |       |
| Score    |          | 80    |
#### User 3:

##### Background Questions
| Question                                                                    | Answer          |
| --------------------------------------------------------------------------- | --------------- |
|                                                                             |                 |
| Is English your native langauage?                                           | Yes             |
|                                                                             |                 |
| Age Range (Under 18-18, 19-22, 23-26, 26-29, 30 and Over)                   | 30 and over     |
|                                                                             |                 |
| Gender (Woman, Man, Non-binary, Prefer to self-describe, Prefer not to say) | Non-binary      |
|                                                                             |                 |
| Highest level of education you have completed?                              | Bachelors       |
|                                                                             |                 |
| Current Occupation?                                                         | Casual academic |
|                                                                             |                 |
| Do you currently own a laptop, desktop or both?                             | Both            |
|                                                                             |                 |
| In general, do you find websites easy to use?                               | No              |
|                                                                             |                 |
| How much time do you typically spend online?                                | 5hrs            |

##### Task Observations & Responses
| Question                                                                                       | Task 1: Create an Account and Login | Task 2: Edit your Profile                                                                                                                                                          | Task 3: Send another User a message | Task 4: Send another user a request |
| ---------------------------------------------------------------------------------------------- | ----------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------- | ----------------------------------- |
|                                                                                                |                                     |                                                                                                                                                                                    |                                     |                                     |
| Observations:                                                                                  |                                     | Choose then upload of picture confusing, image upload as webp error not immeditaely visible, not immediately apparant on academic skills, also took a while to locate the section, |                                     |                                     |
| Overall, I found the task? 7 Easy 1 Very Difficult                                             | 7                                   | 5                                                                                                                                                                                  | 7                                   | 7                                   |
| How confident are you that you completed the task successful? 1 Not Confident 7 Very Confident | 7                                   | 6                                                                                                                                                                                  | 7                                   | 6                                   |
| Any other comments/feedback?                                                                   | Smooth                              |                                                                                                                                                                                    |                                     |                                     |

##### SUS score
| Question | Response | Total |
| -------- | -------- | ----- |
| 1        | 5        | 4     |
| 2        | 1        | 4     |
| 3        | 5        | 4     |
| 4        | 1        | 4     |
| 5        | 5        | 4     |
| 6        | 1        | 4     |
| 7        | 5        | 4     |
| 8        | 1        | 4     |
| 9        | 5        | 4     |
| 10       | 1        | 4     |
|          |          |       |
| Score    |          | 100   |
#### User 4:

##### Background Questions
| Question                                                                    | Answer      |
| --------------------------------------------------------------------------- | ----------- |
|                                                                             |             |
| Is English your native langauage?                                           | Yes         |
|                                                                             |             |
| Age Range (Under 18-18, 19-22, 23-26, 26-29, 30 and Over)                   | 19-22       |
|                                                                             |             |
| Gender (Woman, Man, Non-binary, Prefer to self-describe, Prefer not to say) | Man         |
|                                                                             |             |
| Highest level of education you have completed?                              | High School |
|                                                                             |             |
| Current Occupation?                                                         | Student     |
|                                                                             |             |
| Do you currently own a laptop, desktop or both?                             | Laptop      |
|                                                                             |             |
| In general, do you find websites easy to use?                               | Yes         |
|                                                                             |             |
| How much time do you typically spend online?                                | 7hrs        |
##### Task Observations & Responses
| Question                                                                                       | Task 1: Create an Account and Login | Task 2: Edit your Profile                                                                                   | Task 3: Send another User a message                             | Task 4: Send another user a request                                          |
| ---------------------------------------------------------------------------------------------- | ----------------------------------- | ----------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------- | ---------------------------------------------------------------------------- |
|                                                                                                |                                     |                                                                                                             |                                                                 |                                                                              |
| Observations:                                                                                  |                                     | Image not uploading after selection, maybe increase text size, said the adding skills was straight forward. | Wasn't sure emssage was sent, maybe have a confirmation message | Sent requests and send requests are confusing                                |
| Overall, I found the task? 7 Easy 1 Very Difficult                                             | 6                                   | 6                                                                                                           | 7                                                               | 6                                                                            |
| How confident are you that you completed the task successful? 1 Not Confident 7 Very Confident | 7                                   | 6                                                                                                           | 5                                                               | 5                                                                            |
| Any other comments/feedback?                                                                   |                                     | Auto upload the file, skills could be exploded                                                              | Once sent message should go to outbox.                          | Skills could be a list, Calander nice, Should go to outbox for confirmation. |
##### SUS score
| Question | Response | Total |
| -------- | -------- | ----- |
| 1        | 5        | 4     |
| 2        | 1        | 4     |
| 3        | 5        | 4     |
| 4        | 1        | 4     |
| 5        | 5        | 4     |
| 6        | 1        | 4     |
| 7        | 5        | 4     |
| 8        | 1        | 4     |
| 9        | 4        | 3     |
| 10       | 1        | 4     |
|          |          |       |
| Score    |          | 97.5  |
#### User 5:

##### Background Questions
| Question                                                                    | Answer           |
| --------------------------------------------------------------------------- | ---------------- |
|                                                                             |                  |
| Is English your native langauage?                                           | Yes              |
|                                                                             |                  |
| Age Range (Under 18-18, 19-22, 23-26, 26-29, 30 and Over)                   | 26-29            |
|                                                                             |                  |
| Gender (Woman, Man, Non-binary, Prefer to self-describe, Prefer not to say) | Man              |
|                                                                             |                  |
| Highest level of education you have completed?                              | Bachelors Degree |
|                                                                             |                  |
| Current Occupation?                                                         | IT Consultant    |
|                                                                             |                  |
| Do you currently own a laptop, desktop or both?                             | Both             |
|                                                                             |                  |
| In general, do you find websites easy to use?                               | Yes              |
|                                                                             |                  |
| How much time do you typically spend online?                                | 8hrs             |
##### Task Observations & Responses
| Question                                                                                       | Task 1: Create an Account and Login      | Task 2: Edit your Profile                                                                  | Task 3: Send another User a message          | Task 4: Send another user a request |
| ---------------------------------------------------------------------------------------------- | ---------------------------------------- | ------------------------------------------------------------------------------------------ | -------------------------------------------- | ----------------------------------- |
|                                                                                                |                                          |                                                                                            |                                              |                                     |
| Observations:                                                                                  | Used the valdation feature for flinders, | Didn't press the update buttons after altering fields, losing all data when adding skills, |                                              |                                     |
| Overall, I found the task? 7 Easy 1 Very Difficult                                             | 7                                        | 5                                                                                          | 6                                            | 7                                   |
| How confident are you that you completed the task successful? 1 Not Confident 7 Very Confident | 7                                        | 6                                                                                          | 7                                            | 7                                   |
| Any other comments/feedback?                                                                   |                                          | One button to update all fields, or seperate the updates to different pages                | change URL message to on screen for failures |                                     |

##### SUS score
| Question | Response | Total |
| -------- | -------- | ----- |
| 1        | 4        | 3     |
| 2        | 2        | 3     |
| 3        | 4        | 3     |
| 4        | 1        | 4     |
| 5        | 4        | 3     |
| 6        | 1        | 4     |
| 7        | 4        | 3     |
| 8        | 2        | 3     |
| 9        | 5        | 4     |
| 10       | 1        | 4     |
|          |          |       |
| Score    |          | 85    |

