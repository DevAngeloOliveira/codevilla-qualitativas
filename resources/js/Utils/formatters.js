/**
 * Utilitários para formatação de dados
 */

/**
 * Formata data para padrão brasileiro
 * @param {String} date - Data em formato ISO
 * @param {Boolean} includeTime - Se deve incluir hora
 * @returns {String} Data formatada
 */
export function formatDate(date, includeTime = false) {
    if (!date) return '-';

    const options = {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    };

    if (includeTime) {
        options.hour = '2-digit';
        options.minute = '2-digit';
    }

    return new Date(date).toLocaleString('pt-BR', options);
}

/**
 * Formata número como moeda brasileira
 * @param {Number} value - Valor numérico
 * @returns {String} Valor formatado
 */
export function formatCurrency(value) {
    if (value === null || value === undefined) return 'R$ 0,00';

    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}

/**
 * Formata número com separador de milhares
 * @param {Number} value - Valor numérico
 * @returns {String} Valor formatado
 */
export function formatNumber(value) {
    if (value === null || value === undefined) return '0';

    return new Intl.NumberFormat('pt-BR').format(value);
}

/**
 * Trunca texto com reticências
 * @param {String} text - Texto para truncar
 * @param {Number} length - Tamanho máximo
 * @returns {String} Texto truncado
 */
export function truncate(text, length = 50) {
    if (!text) return '';
    if (text.length <= length) return text;

    return text.substring(0, length) + '...';
}

/**
 * Capitaliza primeira letra
 * @param {String} text - Texto para capitalizar
 * @returns {String} Texto capitalizado
 */
export function capitalize(text) {
    if (!text) return '';
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
}

/**
 * Formata CPF
 * @param {String} cpf - CPF para formatar
 * @returns {String} CPF formatado
 */
export function formatCpf(cpf) {
    if (!cpf) return '';
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
}

/**
 * Formata telefone
 * @param {String} phone - Telefone para formatar
 * @returns {String} Telefone formatado
 */
export function formatPhone(phone) {
    if (!phone) return '';
    phone = phone.replace(/\D/g, '');

    if (phone.length === 11) {
        return phone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (phone.length === 10) {
        return phone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    }

    return phone;
}

/**
 * Remove acentos de string
 * @param {String} text - Texto para normalizar
 * @returns {String} Texto sem acentos
 */
export function removeAccents(text) {
    if (!text) return '';
    return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

/**
 * Gera iniciais de um nome
 * @param {String} name - Nome completo
 * @returns {String} Iniciais
 */
export function getInitials(name) {
    if (!name) return '';

    const parts = name.trim().split(' ');
    if (parts.length === 1) {
        return parts[0].charAt(0).toUpperCase();
    }

    return (parts[0].charAt(0) + parts[parts.length - 1].charAt(0)).toUpperCase();
}

/**
 * Formata bytes em tamanho legível
 * @param {Number} bytes - Tamanho em bytes
 * @returns {String} Tamanho formatado
 */
export function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}
