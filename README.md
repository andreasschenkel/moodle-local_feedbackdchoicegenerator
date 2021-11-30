# Report #

Plugin that helps to generate an xml-file to import into activity feedback to support first and second choise feedback.

![image](https://user-images.githubusercontent.com/31856043/143243636-edea2c80-1397-485f-833e-fdb697e5dd8a.png)


TODO Provide more detailed description here.

## Changelog ##


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
