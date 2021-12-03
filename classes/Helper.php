<?php
namespace report_feedbackchoicegenerator;

use html_writer;

class Helper 
{

     /**
      * generates the options seperated by |
      * @return string with all options without the $selectedoption
      */
     static function generateOptionsList($options, $selectedoption)
     {
          $htmloutput = '';
          $counter = 0;
          foreach ($options as $option) {
               if ($option != $selectedoption) {
                    if ($counter != 0) {
                         $htmloutput = $htmloutput . "|";
                    }
                    $counter++;
                    $htmloutput = $htmloutput . $option . "\n";
               }
          }
          return $htmloutput;
     }

     /**
      * generates nessesary lines at the beginning of the file
      * @return string             
      */
      static function generateDocumentHeaderOpeninglines()
      {
           $output = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
           $output = $output . html_writer::start_tag('FEEDBACK', array('VERSION' => '200701', 'COMMENT' => 'XML-Importfile for mod/feedback')) . "\n";
           $output = $output . html_writer::start_tag('ITEMS') . "\n";
           return $output;
      }

     /**
      * generates nessesary lines at the end of the file to close the opened tags
      * @return string             
      */
      static function generateDocumentLastlines()
      {
           $output = "";
           $output = $output . html_writer::end_tag('ITEMS') . "\n";
           $output = $output . html_writer::end_tag('FEEDBACK') . "\n";
           return $output;
      }

     /**
      * generates the header that can be found in all xml-files for feedback
      * @param int $itemnumber     The number of the actual xml-component to be generated
      * @return string             
      */
     static function generateDocumentHeader($itemnumber)
     {
          $output = "";    
          $output = $output . html_writer::start_tag('ITEM', array('TYPE' => 'info', 'REQUIRED' => '0')) . "\n";
          $output = $output . html_writer::tag('ITEMID', "<![CDATA[$itemnumber]]>") . "\n";
          $output = $output . html_writer::tag('ITEMTEXT', "<![CDATA[]]>") . "\n";   
          $output = $output . html_writer::tag('ITEMLABEL', "<![CDATA[]]>") . "\n";
          $output = $output . html_writer::tag('PRESENTATION', "<![CDATA[1]]>") . "\n";    
          $output = $output . html_writer::tag('OPTIONS', "<![CDATA[]]>") . "\n";  
          $output = $output . html_writer::tag('DEPENDITEM', "<![CDATA[0]]>") . "\n";  
          $output = $output . html_writer::tag('DEPENDVALUE', "<![CDATA[]]>") . "\n";
          $output = $output . html_writer::end_tag('ITEM') . "\n";
          return $output;
     }

     /**
      * generates the pagebrakes to seperate the different options
      * @param int $itemnumber     The number of the actual xml-component to be generated
      */
     static function generatePagebreak($itemnumber)
     {
          $output = "";
          $output = $output . html_writer::start_tag('ITEM', array('TYPE' => 'pagebreak', 'REQUIRED' => '0')) . "\n"; 
          $output = $output . html_writer::tag('ITEMID', "<![CDATA[$itemnumber]]>") . "\n";
          $output = $output . html_writer::tag('ITEMTEXT', "<![CDATA[]]>") . "\n";   
          $output = $output . html_writer::tag('ITEMLABEL', "<![CDATA[]]>") . "\n";
          $output = $output . html_writer::tag('PRESENTATION', "<![CDATA[]]>") . "\n";    
          $output = $output . html_writer::tag('OPTIONS', "<![CDATA[]]>") . "\n";  
          $output = $output . html_writer::tag('DEPENDITEM', "<![CDATA[0]]>") . "\n";  
          $output = $output . html_writer::tag('DEPENDVALUE', "<![CDATA[]]>") . "\n";
          $output = $output . html_writer::end_tag('ITEM') . "\n";
          return $output;
     }

     /**
      * generates the list of options for first or second choice
      * @param integer $level      indicates if first choice oder second choise   
      * @param int $itemnumber     The number of the actual xml-component to be generated
      * @param int $firstchoicereferencenumber Number for to reference to in the second second choice
      * @param string $allOptionsToAdd  
      * @param string $option      DEPENDVALUE
      */
     static function generateSelectionOverview($level, $itemnumber, $firstchoicereferencenumber, $allOptionsToAdd, $option)
     {
          if ($level === 1) {
               $choicelabel = get_string('firstchoicelabel', 'report_feedbackchoicegenerator');
               $firstchoicereferencenumber = 0;
          } else {
               $choicelabel = get_string('secondchoicelabel', 'report_feedbackchoicegenerator');;
          }
          $output = "";
          $output = $output . html_writer::start_tag('ITEM', array('TYPE' => 'multichoice', 'REQUIRED' => '0')) . "\n";
          $output = $output . html_writer::tag('ITEMID', "<![CDATA[$itemnumber]]>") . "\n";
          $output = $output . html_writer::tag('ITEMTEXT', "<![CDATA[$choicelabel]]>") . "\n";
          $output = $output . html_writer::tag('ITEMLABEL', "<![CDATA[$choicelabel auswählen]]>") . "\n";
          $output = $output . html_writer::tag('PRESENTATION', "<![CDATA[r>>>>>$allOptionsToAdd]]>") . "\n";
          $output = $output . html_writer::tag('OPTIONS', "<![CDATA[h]]>") . "\n";  
          $output = $output . html_writer::tag('DEPENDITEM', "<![CDATA[$firstchoicereferencenumber]]>") . "\n";
          $output = $output . html_writer::tag('DEPENDVALUE', "<![CDATA[$option]]>") . "\n";
          $output = $output . html_writer::end_tag('ITEM') . "\n";
          return $output;
     }

     /**
      * generates the xml-code for the label
      * @param $xmlWriterPlus      
      * @param int $itemnumber     The number of the actual xml-component to be generated
      * @param int $firstchoicereferencenumber Number for to reference to in the second second choice
      * @param string $option      DEPENDVALUE
      */
     static function generateLabel($itemnumber, $firstchoicereferencenumber, $option)
     {
          $output = "";
          $output = $output . html_writer::start_tag('ITEM', array('TYPE' => 'label', 'REQUIRED' => '0')) . "\n";
          $output = $output . html_writer::tag('ITEMID', "<![CDATA[$itemnumber]]>") . "\n";
          $output = $output . html_writer::tag('ITEMTEXT', "<![CDATA[]]>") . "\n";
          $output = $output . html_writer::tag('ITEMLABEL', "<![CDATA[]]>") . "\n";
          $output = $output . html_writer::tag('PRESENTATION', "<![CDATA[$option " . get_string('firstchoicelabel', 'report_feedbackchoicegenerator') . "]]>") . "\n";
          $output = $output . html_writer::tag('OPTIONS', "<![CDATA[]]>") . "\n";  
          $output = $output . html_writer::tag('DEPENDITEM', "<![CDATA[$firstchoicereferencenumber]]>") . "\n";
          $output = $output . html_writer::tag('DEPENDVALUE', "<![CDATA[$option]]>") . "\n";
          $output = $output . html_writer::end_tag('ITEM') . "\n";
          return $output;
     }

}
