# FUSS User Research and Low Fidelity Design by HF Tonsley Team 3 

## Project Proposal


### Website Concept

Flinders University Skill Share (FUSS) website will be for students to swap a digital token, called a "FUSScredit", for an hour of service from another student. The service could be either an academic or non-academic endeavour. Examples could be; helping another student with learning how to code in C++, helping move houses, or tutoring in a specific topic.

The website will also have the functionality to be able to help arrange the date and time for this.


### Target Audience Profile

The target audience for this website are students of Flinders University. According to <i>Student and Staff Numbers</i> (2025) there were 17,514 students studying at Flinders in 2024. These had a spread of 12,863 Australian students, 4,015 international students studying on-campus and an additional 636 that were studying offshore (<i>Student and Staff Numbers </i>, 2025).

Furthermore, the student group was split into 11,006 female students, 6,454 Male students and 54 Intersex/Unspecified. As well, while there were was not definitive data available, assumption can be made for a diverse age range of ~17-60+. Other assumptions are that there are diverse values, interests and lifestyles in such a large group. 


### Scope Statement

The scope of this website project will include front-end and back-end development. Languages within scope are HTML, CSS and Javascipt for the front-end development, with PHP and MySQL used for the back-end. Markdown will be used for documentation. The following are basic features that will be implemented;
- User Profiles including;
    - Personal details
        - Name
        - College
        - Degree
        - Year
        - Bio
        - Profile Picture
    - Skills Offered
    - Skills Requested
    - Current FUSSCredit Balance
    - Transaction History
    - Review Score
    - Availability for Requests

- Secure Registration and Login
    - Email Verification 
    - Password Hashing

- Skill Requests
    - Browse/Search of specific skills/services
    - Filters
        - Skill Category
        - Topics
        - Academic Year
        - Availability
    - Requesting the Service

- Review System

- Messaging System

- Admin Dashboard
    - Overview of System Metrics
    - Student Account Management
        - View, edit, suspend or delete
    - Manually add FUSSCredits
    - Content Moderation

These will be supported/implemented via back-end functionality, examples being input forms writing to a database to store users information like the amount of credits for a user and a historical database to store the transactional history of FUSSCredit transactions.            


## User Research Report
### Research Methods
#### Research
In order to create a system that understands the target audience, a variety of different methods can be used. Each method adds additional unique information that when combined create a strong foundation for design and decision making.

#### Surveys
Surveys are a useful method for gathering large amounts of data from the student body. They can help identify the most likely users of our system as well as the reasons behind their use. This data can show common trends and students priorities such as which areas of study students are interested in.

#### Interviews
Interviews provide important insights into each users experience, expectations and needs. It won't represent the whole group of students who may use our website however it allows for deeper exploration of peoples perspectives and opinions. This can be valuable in finding out what motivates and fustrates the user which may not be shown in surveys.

#### Focus Groups
Focus groups offer a chance to observe discussions among students in a group setting. This method is effective for identifying shared concerns, exploring different ideas, and testing early concepts. Group interactions can also create ideas and show patterns that might not be shown through individual feedback such as interviews and surveys.

#### Observation and Usability Testing
Observational methods including user testing can help show how students currently look for support or engage with other assistance systems. During later stages of development, usability testing allows us to evaluate how students interact with a prototype of the website. This helps to identify usability issues, navigation difficulties, and areas where the design may need changes.

### User Personas

#### Provider:
<img src="../imgs/UserPersonas/Matthew Jacob Persona.png">


#### User:
<img src="../imgs/UserPersonas/Athena Werner Persona.png">

#### Admin:
<img src="../imgs/UserPersonas/Diego Martinez Persona.png">

### Competitor Analysis
Direct competitor: Thinkswap.com 

Thinkswap is Australia's largest student contributed study tool. Students can exchange notes, past essays and guides to earn Exchange credits, which can then be used to access other materials. Thinkswap contains a library with over 200,000 resources, all accessible internationally. Students who upload their own content to the website can access new study resources for free. 

Thinkswap differs from FUSS as it is solely based on academic resources not on dynamic skills and services. Thinkswap operates through the Exchange credit system,but students can also pay to access content.Thinkswap faces academic integrity concerns due to students potentially plagiarising other students' works, but the website ensures integrity through the use of plagiarism detection tools and moderation by a team.

Thinkswap is a robust platform purely for exchanging study materials while FUSS serves as a better model for students due to its secure registration process, peer ratings, variety of skills and services offered, and internal messaging system. 

Direct competitor: Timebanking.com.au 

Timebanking is essentially a free community program that offers people the chance to exchange skills or services, reflecting the needs and interests of people within the community. It operates in the same way as the FUSS application, where for every hour of service a person provides, they receive an hour back. Timebanking has a small user base and heavily relies on volunteer coordinators to operate.

Timebanking differs from FUSS because it relies on creating connections through local community events and sharing skills. Registration for Timebanking is open to everyone; therefore,the services offered  can vary. This system can result in user verification and safety issues if proper systems of moderation are not implemented. Timebanking also struggles to build strong community engagement due to a lack of adoption or information. 

FUSS can take advantage of these weak points by partnering with student unions or clubs to increase engagement and potentially embedding the platform into student workflows. FUSS is also more reliable due to its secure registration process and peer review system.

## Information Architecture

### Sitemap


<img src="../imgs/Sitemap/Site Map.png">

### User Flow Diagrams
#### Requesting a Service
<img src="../imgs/UserFlowDiagrams/User flow diagram 1.png">

#### Messaging a User 
<img src="../imgs/UserFlowDiagrams/User flow diagram 2.png">

#### Admin- Adjusting FUSSCredits
<img src="../imgs/UserFlowDiagrams/User flow diagram 3.png">

### Wire Frames
#### Admin Dashboard
<img src="../imgs/AnnotatedWireframes/AnnotatedAdminDashboard.png">

#### Creating a Request
<img src="../imgs/AnnotatedWireframes/AnnotatedServiceRequest.png">

#### Editing a Profile
<img src="../imgs/AnnotatedWireframes/AnnotatedManageProfile.png">

#### Sign-In Page
<img src="../imgs/AnnotatedWireframes/AnnotatedSignIn.png">

#### Student Dashboard
<img src="../imgs/AnnotatedWireframes/AnnotatedDashboard.png ">

### Storyboards

#### Story of Account Deletion
<img src="../imgs/Storyboards/AccountDeletion/StoryboardAccountDeletion.png">

#### Story of Adding Additional Skills
<img src="../imgs/Storyboards/AddSkill/StoryboardAddSkill.png">

#### Story of Changing Availability
<img src="../imgs/Storyboards/ChangeAvailability/StoryboardChangeAvailability.png">

#### Story of Receiving a Request
<img src="../imgs/Storyboards/ReceiveRequest/StoryboardReceiveRequest.png">

#### Story of Creating a Request
<img src="../imgs/Storyboards/ServiceRequest/StoryboardServiceRequest.png">