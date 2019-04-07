<?php namespace ${namespace}\Forms;

use Kshabazz\Slib\Tools\Utilities;
use Whip\Form;
use Whip\Lash\Validator;

/**
 * Class HtmlForm
 *
 * Common form abilities.
 *
 * @package Suh\Forms
 */
abstract class HtmlForm implements Form
{
    use Utilities;

    /** @var array Client form input. */
    protected $input;

    /** @var \Whip\Lash\Validation */
    protected $validation;

    /**
     * Login constructor.
     *
     * @param \Whip\Lash\Validator $validation
     */
    public function __construct(Validator $validation)
    {
        $this->validation = $validation;
        $this->input = [];
    }

    /**
     * Get error message to display to the client.
     *
     * @return array
     */
    abstract protected function getMessages();

    /**
     * @inheritdoc
     */
    public function getRenderData() : array
    {
        return [ $this->input, 'errors' => $this->validation->getErrors()];
    }
}
