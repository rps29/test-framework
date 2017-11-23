<?php
namespace Content\Page;

// TODO: Figure out why script is failing when RenderObject doesn't use class constructor!
// Might be important for future classes being dependency injected
class RenderObject
{

    /**
     * @var string \Content\Page\Request->_controller::__NAMESPACE__
     */
    public $_namespace;

    /////////////////////////////////////////////////////
    //                  Suggestions.                   //
    /////////////////////////////////////////////////////
    /** TODO: ... RenderObject
     * inject dependencies, e.g. the following objects
     * Header (presenting the header of website view)
     * Footer
     * Body
     * Menu
     * etc.
     * All of those classes must extend a AbstractView class
     * they provide functions:
     * getHtml -> runs functionality, renders HTML
     */


    public function render()
    {
        // Called in Index.php
    }

}
