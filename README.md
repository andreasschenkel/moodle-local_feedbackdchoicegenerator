# Report #

Plugin that helps to generate an xml-file to import into activity feedback to support first and second choise feedback.

![erstzweitwahl](https://user-images.githubusercontent.com/31856043/144657346-a58d6fd1-b3cf-4499-9a60-bf1080575483.gif)

![image](https://user-images.githubusercontent.com/31856043/144513664-fed4377f-1517-44a4-a020-16094002a874.png)

## Changelog ##
[[v1.0.4]]

03.12.2021

- codebeautyfing

[[v1.0.3]]

03.12.2021

- check that length of options is less than maxoptions
- some layoutchanges
- optimize implementation of reseting input
- added missing languagestrings


[[v1.0.2]]

02.12.2021

- use dataurl to be able to download xml-file
- max length of option configurable
- set capability für role editingteacher instead of teacher
- check, if user has capability to view report also by checking the capapility
- do not prevent capability for student
- added missing languagestring feedbackchoicegenerator:view


[[v1.0.1]] beta

[[v1.0.0]] initial


## hint to evaluate the choices with calc-program ##
=WENN(D2<>"";D2;WENN(E2<>"";E2;WENN(F2<>"";F2;WENN(G2<>"";G2;"2.Wahl ist leer"))))


## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/report/feedbackchoicegenerator

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##



This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
