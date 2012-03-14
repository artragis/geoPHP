<?php
namespace danoh_geo\Adapter;
use danoh_geo\Geometry;
/*
 * (c) Camptocamp <info@camptocamp.com>
 * (c) Patrick Hayes
 *
 * This code is open-source and licenced under the Modified BSD License.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * SVGAdapter class : a SVG reader/writer.
 * 
 * Note that it will always return a GeoJSON geometry. This
 * means that if you pass it a feature, it will return the
 * geometry of that feature strip everything else.
 * @author artragis
 * @version 1
 */
class SVGAdapter extends \danoh_geo\Adapter\GeoAdapter{
    
    /**
     *@TODO factoriser
     *read a svg string and parse it to geometry
     * @param string $xmlString 
     * @throws BadXMLException if the xml string is not a valid svg string
     * @return Geometry
     */
    public function read($xmlString){
        $domDoc = new \DOMDocument('1.0','utf-8');
        $domDoc = $domDoc->loadXML($xmlString);
        if(! ($domDoc instanceof \DOMDocument)){
            throw new \BadXMLException('malformed xml',  \BadXMLException::PARSE_ERROR);
        }
        if(!$this->isValidSVG($domDoc)){
            throw new \BadXMLException('well formed xml but wrong svg',  \BadXMLException::WRONG_TYPE);
        }
        //@TODO improve all shape
       // $transformRule = array('title','desc','rect','line'=>'Line','circle','text'=>'LineString');
        $geometry=array();
        foreach($svgTag[0]->childNodes as $tags){
            if($tags->nodeName === 'rect'){
                $x = $tags->getAttribute('x');
                $y = $tags->getAttribute('y');
                $width = $tags->getAttribute('width');
                $height = $tags->getAttribute('width');
                $geometry[]=new \Polygon(array(new \LineString(array(new Point($x,$y),new Point($x+$width,$y))),
                                               new \LineString(array(new Point($x+$width,$y),new Point($x+$width,$y+$height))),
                                               new \LineString(array(new Point($x+$width,$y+$height),new Point($x,$y+$height))),
                                               new \LineString(array(new Point($x,$y+$height),new Point($x,$y)))));
            }else if($tags->nodeName === 'line'){
                $x  = $tags->getAttribute('x1');
                $y  = $tags->getAttribute('y1');
                $x2 = $tags->getAttribute('x2');
                $y2 = $tags->getAttribute('y2');
                $geometry[]=new \LineString(array(new Point($x,$y),new Point($x2,$y2)));
            }else if($tags->nodeName === 'polyline'){
                $lines = array();
                $points = explode(',',$tags->getAttribute('points'));
                for($i = 0;$i<count($points)-3;$i+=2){
                    $lines[]=new \LineString(array(new Point($points[$i],$points[$i+1]),new Point($points[$i+2],$points[$i+3])));
                }
                $geometry[]=new \MultiLineString($lines);
            }else if($tags->nodeName === 'polygon'){
                $lines = array();
                $points = explode(',',$tags->getAttribute('points'));
                for($i = 0;$i<count($points)-3;$i+=2){
                    $lines[]=new \LineString(array(new Point($points[$i],$points[$i+1]),new Point($points[$i+2],$points[$i+3])));
                }
                $geometry[] = new \Polygon($lines);
            }
            
        }
    }
    public function write(Geometry $geometry){
        
    }
    
    private function isValidSVG(\DOMDocument $doc){
        $authorisedTags = array('title','desc','rect','line','circle','text');
        $svgTag = $doc->getElementsByTagName('svg');
        if($svgTag->length !== 1){
            return false;
        }else{
            $children = $svgTag[0]->childNodes;
            foreach($children as $tags){
                if(!in_array(strtolower($tags->nodeName),$authorisedTags) ){
                    return false;
                }
            }
        }
        return true;
    }
}

?>
