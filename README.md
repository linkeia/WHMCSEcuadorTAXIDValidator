### Características principales:

**Validación de Cédula:**
- Verifica que el número de cédula cumpla con el formato oficial (10 dígitos).
- Aplica el algoritmo de validación estándar basado en la suma ponderada.

**Validación de RUC:**
- Compatibilidad con personas naturales, sociedades privadas y entidades públicas.
- Nueva mejora: Excepción del Módulo 11 para RUC de sociedades privadas con secuenciales superiores a 6 dígitos, siguiendo las recomendaciones del SRI.

**Configuraciones del módulo:**
- Activar/desactivar validaciones según las necesidades.
- Personalización de mensajes de error para TAX ID no válidos.

**Registro detallado:**
Registra todas las validaciones y errores en los logs del sistema para facilitar la depuración.

**Instalación**
- Clona este repositorio en la carpeta modules/addons de tu instalación de WHMCS.
- Activa el módulo desde el área administrativa de WHMCS: Configuración > Módulos Extra.
- Configura las opciones del módulo según tus necesidades.

**Últimas actualizaciones:**
- Excepción en validación del Módulo 11 para RUC de sociedades privadas.
- Implementación basada en las recomendaciones oficiales del SRI.
- Mejora en los mensajes de error, detallando la causa exacta de las validaciones fallidas.
- Optimización del código para separar validaciones entre frontend y backend de WHMCS.

**Contribuciones**
¡Todas las contribuciones son bienvenidas! Si tienes sugerencias o encuentras algún problema, abre un issue o envía un pull request.

### TAX ID Validation for WHMCS
**Description (English)**
This module enables TAX ID validation in WHMCS, specifically for Ecuadorian ID numbers (Cédula) and company registration numbers (RUC). Developed following the guidelines of the Ecuadorian Internal Revenue Service (SRI), it ensures that the entered data complies with Ecuadorian regulations.

**Key Features:**

**Cédula Validation:**
- Ensures the ID number meets the official format (10 digits).
- Uses the standard validation algorithm based on weighted sums.

**RUC Validation:**
- Supports individuals, private companies, and public entities.
- New improvement: Exception for the Modulo 11 validation for private company RUCs with sequential numbers exceeding 6 digits, as per SRI recommendations.

**Module Settings:**
- Enable/disable validations as needed.
- Customize error messages for invalid TAX IDs.

**Detailed Logging:**
Records all validations and errors in the system logs for easy debugging.

**Installation**
- Clone this repository into the modules/addons folder of your WHMCS installation.
- Activate the module from the WHMCS admin area: Setup > Addon Modules.
- Configure the module options according to your needs.

**Latest Updates:**
- Exception for Modulo 11 validation for private company RUCs.
- Implementation based on SRI official recommendations.
- Enhanced error messages with detailed reasons for failed validations.
- Code optimization to separate frontend and backend validations in WHMCS.

**Contributions**
All contributions are welcome! If you have suggestions or encounter any issues, please open an issue or submit a pull request.
