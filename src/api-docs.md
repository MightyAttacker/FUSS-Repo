## API Endpoints

* GET
  * #### get-recurring-availability.php
    * Params
      * userid: string
      * weekstartdate: string
        * Must be in format YYYY-MM-DD
    * Returns
      * weekstartdate: string
        * The same value as was passed in
      * days[]
        * userid: string
          * The same value as was passed in
        * dayindex: int
          * A number 0-6 representing the day of the week
          * Mondays are 0 and Sundays are 6
        * starttime: string
          * Time with format HH:MM (Need to change code)
        * endtime
          * Time with format HH:MM (Need to change code)
          * Will be later than starttime and won't cross midnight
  * #### get-daily-availability.php
    * Params
      * userid: string
      * startdate: string
        * Must be in format YYYY-MM-DD
      * enddate: string
        * Must be in format YYYY-MM-DD
        * Must be later than or equal to startdate
        * Results include both ends
    * Returns
      * userid: string
      * startdate: string
        * The same value as was passed in
      * enddate: string
        * The same value as was passed in
      * days[]
        * date: string
          * Will be between or equal to the ends
        * starttime: string
          * Time with format HH:MM (Need to change code)
        * endtime: string
          * Time with format HH:MM (Need to change code)
          * Will be later than starttime
        * reason: string
          * Will be either "manual" or "request"

* POST
  * #### update-recurring-availability.php
    * weekstartdate: string
      * Must be in format YYYY-MM-DD
      * Will be converted to latest Monday from this date
    * days[]
      * dayindex: string
        * Number representing the day of the week. Monday = 0
      * starttime: string
        * HH:MM in 24 hour time
      * endtime: string
        * HH:MM in 24 hour time
      * userid: string
  * #### update-details
    * about: string
    * course: string
    * askills
      * list of strings; valid values are in skills table with academic = 1
    * naskills
      * list of strings; valid values are in skills table with academic = 0
  * #### update-daily-availability.php 
    * userid: string
    * startdate: string
      * Must be in format YYYY-MM-DD
    * enddate: string
      * Must be in format YYYY-MM-DD
      * Must be later than startdate
    * days[]
      * date: string
          * Must be between or equal to the ends
      * starttime: string
          * Time with format HH:MM (Need to change code)
      * endtime: string
          * Time with format HH:MM (Need to change code)
          * Must be later than starttime