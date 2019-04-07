<?php

class PluginName_Sample extends WP_UnitTestCase
{

    function test_get_option_allow_data_success()
    {
        $this->assertEquals(true, '1');
    }
}
