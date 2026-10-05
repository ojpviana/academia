import './bootstrap';

// 1. Interceptador Global para Axios (caso seja usado)
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 419) {
            window.location.reload();
            return new Promise(() => {}); // Trava a execuÃ§Ã£o para nÃ£o estourar erro no console enquanto recarrega
        }
        return Promise.reject(error);
    }
);

// 2. Interceptador Global para Fetch nativo (muito usado no projeto)
const originalFetch = window.fetch;
window.fetch = async function(...args) {
    const response = await originalFetch.apply(this, args);
    if (response.status === 419) {
        window.location.reload();
        return new Promise(() => {}); // Previne que o cÃ³digo tente dar parse(json) na pÃ¡gina de erro
    }
    return response;
};
