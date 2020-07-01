import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import static com.kms.katalon.core.testobject.ObjectRepository.findWindowsObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable
import org.openqa.selenium.Keys as Keys

WebUI.openBrowser('')

WebUI.navigateToUrl('http://smartcampus.uniajc.edu.co:10080/reservaSalas/login')

WebUI.setText(findTestObject('Object Repository/navMI/Page_Reservas/input_Usuario_username'), 'cabolaños')

WebUI.setEncryptedText(findTestObject('Object Repository/navMI/Page_Reservas/input_Contrasea_password'), 'iGDxf8hSRT4=')

WebUI.click(findTestObject('Object Repository/navMI/Page_Reservas/button_Iniciar sesin'))

WebUI.click(findTestObject('Object Repository/navMI/Page_Reservas/a_SEDE CENTRAL'))

WebUI.click(findTestObject('Object Repository/navMI/Page_Reservas/a_SEDE ESTACIN 1'))

WebUI.click(findTestObject('Object Repository/navMI/Page_Reservas/a_SEDE SUR'))

WebUI.closeBrowser()

