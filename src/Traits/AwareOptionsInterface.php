<?php
namespace YesPHP\Traits;

interface AwareOptionsInterface{

            /**
     * Set a single option
     *
     * @param  string $name
     * @param  mixed $value
     * @return self
     */
    public function setOption($name, $value);

        /**
     * Get a single option
     *
     * @param  string       $name           The option to get.
     * @param  mixed|null   $default        (optional) A default value if the option is not yet set.
     * @return mixed
     */
    public function getOption($name, $default = null);

    /**
     * Set renderer options/hints en masse
     *
     * @param array|Traversable $options
     * @throws \Exception
     * @return self
     */
    public function setOptions($options = []);

    /**
     * Get renderer options/hints
     *
     * @return array
     */
    public function getOptions();

    /**
     * Clear any existing renderer options/hints
     *
     * @return self
     */
    public function clearOptions();

}