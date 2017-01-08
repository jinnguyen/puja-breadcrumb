<?php
namespace Puja\Breadcrumb;
class Breadcrumb
{
    protected $data;
    protected $element = '<li class="{FirstLastCss}">%s{Divider}</li>';
    protected $listElement = '<ul>%s</ul>';
    protected $firstCssClassName;
    protected $lastCssClassName;
    protected $divider;
    protected $safeHtml;

    public function __construct($breadcrumbs = array())
    {
        $this->data = array();
        $this->safeHtml = true;
        if ($breadcrumbs) {
            $this->setData($breadcrumbs);
        }
        return $this;
    }

    public function setSafeHtml($safeHtml)
    {
        $this->safeHtml = $safeHtml;
    }

    public function setFirstCssClassName($className)
    {
        $this->firstCssClassName = $className;
        return $this;
    }

    public function setLastCssClassName($className)
    {
        $this->lastCssClassName = $className;
        return $this;
    }

    public function setDivider($divider)
    {
        $this->divider = $divider;
        return $this;
    }

    public function setElement($element)
    {
        if (!empty($element) && strpos($element, '%s') === false) {
            throw new Exception('Element value must have %s');
        }
        $this->element = $element;
        return $this;
    }

    public function setListElement($listElement)
    {
        if (!empty($listElement) && strpos($listElement, '%s') === false) {
            throw new Exception('ListElement value must have %s');
        }
        $this->listElement = $listElement;
        return $this;
    }

    public function add($title, $link)
    {
        $this->data[] = array('title' => $title, 'link' => $link);
        return $this;
    }

    public function deleteLastItem()
    {
        array_pop($this->data);
        return $this;
    }

    public function deleteAll()
    {
        $this->data = array();
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Gets the current amount of breadcrumbs
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Checks whether there are any breadcrumbs added yet.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    public function render()
    {
        if ($this->isEmpty()) {
            return null;
        }

        $breadcrumbs = array();
        foreach ($this->data as $key => $breadcrumb) {

            if ($this->safeHtml) {
                $breadcrumb['title'] = htmlentities($breadcrumb['title']);
            }

            $breadcrumb['divider'] = $this->divider;
            $breadcrumb['firstLastCss'] = '';

            if ($key === 0) {
                $breadcrumb['firstLastCss'] = $this->firstCssClassName;
            }

            if ($key === $this->count() - 1) {
                $anchor = $breadcrumb['title'];
                $breadcrumb['divider'] = '';
                $breadcrumb['firstLastCss'] = $this->lastCssClassName;
            } else {
                $anchor = '<a href="' . $breadcrumb['link'] . '">' . $breadcrumb['title'] . '</a>';
            }

            $breadcrumbs[$key] = $anchor;

            if ($this->element) {
                $breadcrumbs[$key] = str_replace(
                    array('%s', '{FirstLastCss}', '{Divider}'),
                    array($anchor, $breadcrumb['firstLastCss'], $breadcrumb['divider']),
                    $this->element
                );
            }
        }

        $breadcrumbs = implode('', $breadcrumbs);
        if (empty($this->listElement)) {
            return $breadcrumbs;
        }

        return str_replace('%s', $breadcrumbs, $this->listElement);


    }

    protected function setData(array $breadcrumbs = array())
    {
        foreach ($breadcrumbs as $key => $breadcrumb) {
            if (!$this->validate($breadcrumb)) {
                throw new Exception(
                    'Only accepts correctly formatted arrays, but at least one of the values was misformed: ' . print_r($breadcrumb, true) .
                    ' (the correct format [title => Title, url => URL])'
                );
            }

            $this->add($breadcrumb['title'], $breadcrumb['link']);
        }
    }

    protected function validate($breadcrumb)
    {
        if (empty($breadcrumb['title']) || empty($breadcrumb['link'])) {
            return false;
        }

        return true;
    }
}