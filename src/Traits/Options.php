<?php
namespace YesPHP\Traits;

use Traversable;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Session\SaveHandler\SaveHandlerInterface;

trait Options{

            /**
     * Renderer options
     * @var array
     */
    protected $options = [];

        /**
     * Set a single option
     *
     * @param  string $name
     * @param  mixed $value
     * @return self
     */
    public function setOption($name, $value)
    {
        $this->options[(string) $name] = $value;
        return $this;
    }

    /**
     * Get a single option
     *
     * @param  string       $name           The option to get.
     * @param  mixed|null   $default        (optional) A default value if the option is not yet set.
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        $name = (string) $name;
        return array_key_exists($name, $this->options) ? $this->options[$name] : $default;
    }

    /**
     * Set renderer options/hints en masse
     *
     * @param array|Traversable $options
     * @throws \Exception
     * @return self
     */
    public function setOptions($options = [])
    {
        // Assumption is that lowest common denominator for renderer configuration
        // is an array
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if (! is_array($options)) {
            throw new \Exception(sprintf(
                '%s: expects an array, or Traversable argument; received "%s"',
                __METHOD__,
                (is_object($options) ? get_class($options) : gettype($options))
            ));
        }

        $this->options = $options;
        return $this;
    }

    /**
     * Get renderer options/hints
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Clear any existing renderer options/hints
     *
     * @return self
     */
    public function clearOptions()
    {
        $this->options = [];
        return $this;
    }

}