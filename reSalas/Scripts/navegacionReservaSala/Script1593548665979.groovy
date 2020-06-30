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
import com.kms.katalon.core.windows.keyword.WindowsBuiltinKeywords as Windows
import internal.GlobalVariable as GlobalVariable
import org.openqa.selenium.Keys as Keys

WebUI.openBrowser('')

WebUI.navigateToUrl('http://smartcampus.uniajc.edu.co:10080/reservaSalas/login')

WebUI.setText(findTestObject('Object Repository/navRS/Page_Reservas/input_Usuario_username'), 'cabolaños')

WebUI.setEncryptedText(findTestObject('Object Repository/navRS/Page_Reservas/input_Contrasea_password'), 'iGDxf8hSRT4=')

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas/button_Iniciar sesin'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas/em_Salas Disponibles_fa fa-check-square-o'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Consulta Salas Disponibles/button_Reservar'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_lista x mes'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_semana'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_lista x semana'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_dia'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/span_PENDIENTE POR APROBAR_fc-icon fc-icon-_ec5e2a'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/span_PENDIENTE POR APROBAR_fc-icon fc-icon-_ec5e2a'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/span_PENDIENTE POR APROBAR_fc-icon fc-icon-_ec5e2a'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_mes'))

WebUI.doubleClick(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_PENDIENTE POR APROBAR_fc-next-button_d7cd9e'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_PENDIENTE POR APROBAR_fc-next-button_d7cd9e'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/span_Crear Reserva'))

WebUI.click(findTestObject('Object Repository/navRS/Page_Reservas  Crear Reserva/button_Cerrar'))

WebUI.closeBrowser()

