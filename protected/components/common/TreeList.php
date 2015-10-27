<?php
    /**
     *
     * Load Data  parse to Tree list
     * @author Thangtv - thangtv2@vega.com.vn
     * @param array $data
     * @param int $primary // primary Key in table
     * @param int $parField // Parent id field in table
     * @param string $nameField // Name or Title display in list
     * @param int $type // 1- For list style ; 2 for select box
     * @return ARRAY
     */
class TreeList {

    private $data;
    private $primary;
    private $parField;
    private $nameField;
    private $type;

    public function __construct($data, $option) {
        $this->data = $data;
        $this->parField = $option['parend_id'];
        $this->nameField = $option['name'];
        $this->primary = $option['primary'];
        $this->type = $option['type'] ? $option['type'] : 1;
    }

    public function getTreeList() {
        $result = $this->data;

        if (!isset($num) || $num == 0) {
            $num = count($result);
        }
        $children = array();

        if ($result) {
            // first pass - collect children
            foreach ($result as $v) {
                $pt = $v[$this->parField];
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }
        // second pass - get an indent list of the items
        $items = $this->treerecurse(!empty ($result)?$result[0][$this->parField]:0, '', array(), $children, 9999, 0, $this->type);
        // third pass, set into different menus
        foreach ($items as $key => $item) {
            $data[$key] = $item;
        }
        return !empty($data) ? $data : array();
    }

    private function treerecurse($id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type = 1) {
        if (@$children[$id] && $level <= $maxlevel) {
            foreach ($children[$id] as $v) {
                $id = $v[$this->primary];

                if ($type == 1) {
                    $pre = '<sup>|_</sup>&nbsp;';
                    $spacer = '.&nbsp;&nbsp;&nbsp;';
                } else {
                    $pre = '- ';
                    //$spacer = '&nbsp; &nbsp;';
                    $spacer = '-  ';
                }

                if ($v[$this->parField] == 0) {
                    $txt = $v[$this->nameField];
                } else {
                    $txt = $pre . $v[$this->nameField];
                }
                $pt = $v[$this->parField];
                $list[$id] = $v;
                $list[$id][$this->nameField] = "$indent$txt";
                $list[$id]['real_name'] =$v[$this->nameField];
                $list[$id]['children'] = count(@$children[$id]);
                $list = $this->treerecurse($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $type);
            }
        }
        return $list;
    }

    private function treerecurse_object($id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type = 1) {
        if (@$children[$id] && $level <= $maxlevel) {
            foreach ($children[$id] as $v) {
                $id = $v[$this->primary];
                if ($type == 1) {
                    $pre = '<sup>|_</sup>&nbsp;';
                    $spacer = '.&nbsp;&nbsp;&nbsp;';
                } else {
                    $pre = '- ';
                    $spacer = '&nbsp; &nbsp;';
                    $spacer = '-  ';
                }

                if ($v[$this->parField] == 0) {
                    $txt = $v[$this->nameField];
                } else {
                    $txt = $pre . $v[$this->nameField];
                }
                $pt = $v[$this->parField];
                $list[$id] = $v;
                $list[$id][$this->nameField] = "$indent$txt";
                $list[$id]['children'] = count(@$children[$id]);
                $list = $this->treerecurse($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $type);
            }
        }
        return $list;
    }

    function objectToArray($object) {
        echo "<pre>";
        print_r($object);
        exit;
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map(array($this, 'objectToArray'), $object);
    }

}