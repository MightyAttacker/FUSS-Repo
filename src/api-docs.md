## API Endpoints

* GET
  * get-availability.php
    * http://localhost:8010/Webpages/get-availability.php?startdate=YYYY-MM-DD&userid=testuser1
* POST
  * update-recurring-availability.php
    * weekstartdate: YYYY-MM-DD - Will be converted to latest Monday from this date
    * days - array of objects containing following keys
      * dayindex: Number representing the day of the week. Monday = 0
      * starttime: HH:MM in 24 hour time
      * endtime: HH:MM in 24 hour time. Must be later than starttime
      * userid: internal user id
  * update-details
    * about: string
    * course: string
    * askills
      * list of strings; valid values are in skills table with academic = 1
    * naskills
      * list of strings; valid values are in skills table with academic = 0