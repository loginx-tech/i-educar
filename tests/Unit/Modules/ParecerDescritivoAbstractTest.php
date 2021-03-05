<?php


/**
 * ParecerDescritivoAbstractTest class.
 *
 * @author      Eriksen Costa Paixão <eriksen.paixao_bs@cobra.com.br>
 *
 * @category    i-Educar
 *
 * @license     @@license@@
 *
 * @package     Avaliacao
 * @subpackage  UnitTests
 *
 * @since       Classe disponível desde a versão 1.1.0
 *
 * @version     @@package_version@@
 */
class ParecerDescritivoAbstractTest extends UnitBaseTest
{
    protected $_entity = null;

    protected function setUp(): void
    {
        $this->_entity = new Avaliacao_Model_ParecerDescritivoAbstractStub();
    }

    public function testEntityValidators()
    {
        $validators = $this->_entity->getValidatorCollection();
        $this->assertInstanceOf('CoreExt_Validate_Choice', $validators['etapa']);
        $this->assertInstanceOf('CoreExt_Validate_String', $validators['parecer']);

        // Verifica se as opções de etapa incluem 'An'
        $this->assertTrue(in_array('An', $validators['etapa']->getOption('choices')));
    }
}
