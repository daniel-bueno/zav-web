/**
 * Remove caracteres não numéricos de uma string
 * @param {string} value
 * @returns {string}
 */
const removeNonDigits = (value) => value.replace(/[^\d]+/g, '');

/**
 * Verifica se todos os dígitos são iguais
 * @param {string} value
 * @returns {boolean}
 */
const hasAllDigitsEqual = (value) => /^(\d)\1+$/.test(value);

/**
 * Calcula o dígito verificador do CNPJ
 * @param {string} numbers - Números do CNPJ sem os dígitos verificadores
 * @param {number} position - Posição do dígito verificador (12 ou 13)
 * @returns {number}
 */
const calculateVerifierDigit = (numbers, position) => {
    const length = position - 1;
    let sum = 0;
    let pos = length - 7;

    for (let i = length; i >= 1; i--) {
        sum += parseInt(numbers.charAt(length - i)) * pos--;
        if (pos < 2) pos = 9;
    }

    const result = sum % 11;
    return result < 2 ? 0 : 11 - result;
};

/**
 * Valida um número de CNPJ
 * @param {string} value - CNPJ para ser validado
 * @returns {boolean} - Retorna true se o CNPJ é válido, false caso contrário
 * @example
 * import { validateCNPJ } from '@/core/validators/documents/cnpj.validator';
 *
 * const isValid = validateCNPJ('43.588.639/0001-42'); // true
 * const isInvalid = validateCNPJ('11.111.111/1111-11'); // false
 */
export const validateCNPJ = (value) => {
    if (!value) return false;

    const cnpj = removeNonDigits(value);

    if (cnpj.length !== 14) return false;
    if (hasAllDigitsEqual(cnpj)) return false;

    const numbers = cnpj.substring(0, 12);
    const digits = cnpj.substring(12);

    const digit1 = calculateVerifierDigit(numbers, 12);
    if (digit1 !== parseInt(digits.charAt(0))) return false;

    const digit2 = calculateVerifierDigit(numbers + digit1, 13);
    if (digit2 !== parseInt(digits.charAt(1))) return false;

    return true;
};

/**
 * Formata um CNPJ para o formato XX.XXX.XXX/XXXX-XX
 * @param {string} value - CNPJ para ser formatado
 * @returns {string} CNPJ formatado
 * @example
 * import { formatCNPJ } from '@/core/validators/documents/cnpj.validator';
 *
 * const formatted = formatCNPJ('43588639000142'); // '43.588.639/0001-42'
 */
export const formatCNPJ = (value) => {
    const numbers = removeNonDigits(value);
    return numbers.replace(
        /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/,
        '$1.$2.$3/$4-$5'
    );
};

/**
 * Configuração da máscara para input de CNPJ
 * Para uso com a biblioteca maska
 */
export const CNPJ_MASK = '##.###.###/####-##';
