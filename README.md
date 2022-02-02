# 1. and 2. ranked choice in feedback-generator #

A: How to use 

B: Settings 

C: Capabilitys

D: Changelog 

E: hint to evaluate the choices with calc-program 

F: Installing via uploaded ZIP file

G: Installing manually


### A: How to use ###

Plugin that helps to generate an xml-file to import into activity feedback to support ranked first and second choise with the activity feedback.

You can generate the needed XML-file with the questions and then you can import this XML-file into the activity feedback.

See this animated gif to find out, how to use this localplugin as an generator and how to use the generated code as questions in feedback activity in moodle.

![erstzweitwahl](https://user-images.githubusercontent.com/31856043/144657346-a58d6fd1-b3cf-4499-9a60-bf1080575483.gif)

![image](https://user-images.githubusercontent.com/31856043/147839212-c09e9810-af3f-4931-a7a8-be0a683321e2.png)

You can enter options and then click generate a xml-code that hast do be saved as xml-file. 
There ar two ways to save this file. 
1. You can copy the generated xml-code into an texteditor ans save the file. 

or

2. The xml-file can be saved with rightclick and choosing "save file as"

This saved file then can be used for import in moodle-feedback activity.



### B: Settings ###

- You can activate the generator in the settings of the local plugin (default is no for inactiv generator).
- You can set the maximum number of options (default is 40).
- You can set the length of each option '(default is 30)

![image](https://user-images.githubusercontent.com/31856043/147839230-3c9248d2-97ab-4544-8a1d-13343d93089f.png)



### C: Capabilitys ###

By default only editing teacher can use this generator. If other roles should be able to use the generator the capabilitys have to be set.

![image](https://user-images.githubusercontent.com/31856043/147839457-719c90cb-3b93-4c4b-9d14-0893228bf3d8.png)




### D: Changelog ###

[[v2.0.5]]

- fixed: delete "ranked" from pluginname and refactored to previous name feedbackchoicegenerator


[[v2.0.4]]

- fixed: add "ranked" to pluginname and refactored to new name feedbackcankedchoicegenerator
- fixed: Wrong link URL if Moodle not installed in the server root. 
- fixed: wrong namespaces
- fixed: pull request with correct language strings
- fixed: do not hard-code the word "Option"



[[v2.0.3]]

- setting to allow generator on frontpage with courseid=1. Use URL moodleurl/local/feedbackchoicegenerator/index.php?id=1'


[[v2.0.2]]

- 31.12.2021 css and layout improvements, add link back to the course, bug with activating generator in settings-page of the plugin
[[v2.0.1]]

[[v2.0.0]]

- 12.12.2021 to support moodle styleguide use code checker to find codebeautyfing issues
- 20.12.2021 add privacy provider implementation to inform that no private date is stored
- 29.12.2021 transfer code from plugintype report to local
- 30.12.2021 settings-problem solved

[[v1.0.5]]
unknown

[[v1.0.4]]

- 03.12.2021 codebeautyfing

[[v1.0.3]]

- 03.12.2021 check that length of options is less than maxoptions
- 03.12.2021 some layoutchanges
- 03.12.2021 optimize implementation of reseting input
- 03.12.2021 added missing languagestrings


[[v1.0.2]]

- 02.12.2021 use dataurl to be able to download xml-file
- 02.12.2021 max length of option configurable
- 02.12.2021 set capability für role editingteacher instead of teacher
- 02.12.2021 check, if user has capability to view report also by checking the capapility
- 02.12.2021 do not prevent capability for student
- 02.12.2021 added missing languagestring feedbackchoicegenerator:view


[[v1.0.1]] beta

[[v1.0.0]] initial


### E: hint to evaluate the choices with calc-program ###
=WENN(D2<>"";D2;WENN(E2<>"";E2;WENN(F2<>"";F2;WENN(G2<>"";G2;"2.Wahl ist leer"))))


### F: Installing via uploaded ZIP file ###

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

### G: Installing manually ###

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/local/feedbackchoicegenerator

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

### License ###



This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
