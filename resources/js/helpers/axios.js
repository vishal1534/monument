import axios from 'axios';
import store from "../store/store";

let authToken = localStorage.getItem('auth_token');

if (authToken) {
    authToken = authToken.replace(/['"]+/g, '');
    axios.defaults.withCredentials = true;
    axios.defaults.headers['Accept'] = 'application/json';
    axios.defaults.headers['Content-Type'] = 'application/json';
    axios.defaults.headers['Authorization'] = `Bearer ${authToken}`;
}
/**
 *  Production Axios Calls
 * */
export const deleteProductionRecord = function (id, callback, callbackError) {
    const url = '/api/productions/' + id;
    const instance = axios.create();
    instance
        .delete(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

/**
 *  Cemetery Axios Calls
 * */
export const cemeteryInfo = function (params, callback, callbackError) {
    const url = '/api/cemetery/info/' + params;
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};
/**
 *  supplier Axios Calls
 * */
export const supplierInfo = function (callback, callbackError) {
    const url = '/api/supplier';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

export const userFamiliesInfo = function (callback, callbackError) {
    const url = '/api/user/families';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};
export const customerOrderInfo = function (params, callback, callbackError) {
    const url = 'api/' + params.module + '/' + params.methodName;
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};
export const getCemeteries = function (callback, callbackError) {
    const url = '/api/cemetery';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}

/**
 *  Product Axios Calls
 * */
export const getProduct = function (id, callback, callbackError) {
    const url = '/api/product/get/' + id;
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

/**
 *  Order Axios Calls
 * */
export const savePayment = function (data, callback, callbackError) {
    const url = '/api/order/addPayment';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};
export const searchOrderProducts = function (data, callback, callbackError) {
    const url = '/api/order/searchProducts';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

/**
 *  Quote Axios Calls
 * */
export const searchProducts = function (data, callback, callbackError) {
    const url = '/api/quote/searchProducts';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

/**
 *
 * Purchase Order calls
 */
export const searchPoProducts = function (data, callback, callbackError) {
    const url = '/api/PoOrder/searchProducts';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

/**
 *  Company Axios Calls
 * */
export const companyInfo = function (callback, callbackError) {
    const url = '/api/company/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};
export const userInfo = function (callback, callbackError) {
    const url = '/api/user/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};
/**
 *  Department Axios Calls
 * */
export const departmentInfo = function (callback, callbackError) {
    const url = '/api/department/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

export const paperLocationInfo = function (callback, callbackError) {
    const url = '/api/paperLocation/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

/**
 *  Service Axios Calls
 * */
export const serviceInfo = function (callback, callbackError) {
    const url = '/api/service/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};


/**
 *  Simple Axios Calls
 * */
export const simpleInfo = function (callback, callbackError) {
    const url = '/api/simple/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

/**
 *  Composite Axios Calls
 * */
export const compositeInfo = function (callback, callbackError) {
    const url = '/api/composite/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

export const searchCompositeProducts = function (data, callback, callbackError) {
    const url = '/api/composite/searchProducts';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};
export const deleteCompositeProduct = function (id, callback, callbackError) {

    const url = '/api/composite/deleteProduct/' + id;
    const instance = axios.create();
    instance
        .post(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}

/**
 * Monument Axios Calls
 * */
export const removeMonumentComponent = function (params, callback, callbackError) {

    const url = '/api/monument/toggleComponent';
    const instance = axios.create();
    instance
        .post(url, params)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const monumentInfo = function (callback, callbackError) {
    const url = '/api/monument/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

/**
 * Porcelain Axios Calls
 * */
export const porcelainInfo = function (callback, callbackError) {
    const url = '/api/porcelain/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

export const reportInfo = function (params, callback, callbackError) {
    let module = params.module;
    let method = params.method;
    const url = '/api/' + module + '/' + method;
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callback && callbackError(error);
        });
};
export const compositeReportFilterRecord = function (params, callback, callbackError) {
    let module = params.module;
    let method = params.method;
    let data = params.filterData;
    const url = '/api/' + module + '/' + method;
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callback && callbackError(error);
        });
};

/**
 * Delivery WOrk Order Axios Calls
 * */
export const deliveryWorkOrderInfo = function (callback, callbackError) {
    const url = '/api/deliveryWorkOrder/info';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response.data);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

};

/**
 * Stores Axios Calls
 * */
export const getCompanies = function (callback, callbackError) {
    const url = '/api/company';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}

/**
 * Collaboration & Correspondence Tasks
 * */
export const deleteTask = function (data, callback, callbackError) {

    const url = '/api/' + data.module + '/deleteTask/' + data.id;
    const instance = axios.create();
    instance
        .post(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const sendCustomerViewMail = function (params, data, callback, callbackError) {
    let module = params.module;

    const url = '/api/' + module + '/sendCustomerViewMail';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};
export const sendApprovalMail = function (params, data, callback, callbackError) {
    let module = params.module;

    const url = '/api/' + module + '/sendApprovalMail';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

/**
 * Authentication
 * */
export const registerUser = function (data, callback, callbackError) {

    const url = '/api/register';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const loginUser = function (data, callback, callbackError) {

    const url = '/api/login';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const logoutUser = function (callback, callbackError) {

    const url = '/api/logout';
    const instance = axios.create();
    instance
        .post(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const verifyUser = function (data, callback, callbackError) {

    const url = '/api/verifyUser';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const forgetPassword = function (data, callback, callbackError) {

    const url = '/api/forgetPassword';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const resetPassword = function (data, callback, callbackError) {

    const url = '/api/resetPassword';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const createPassword = function (data, callback, callbackError) {
    const url = '/api/createPassword';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const authUser = function (callback, callbackError) {

    const url = '/api/user';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const userDetail = function (callback, callbackError) {

    const url = '/api/userDetail';
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const isLoggedIn = function (callback, callbackError) {

    const url = '/api/authenticated';
    const axiosConfig = {
        'Content-Type': 'application/json',
    };
    const instance = axios.create();
    instance
        .get(url, { headers: axiosConfig })
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });

}
export const updateProfile = function (data, callback, callbackError) {

    const url = '/api/updateProfile';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}


/**
 * Generic Axios Calls
 * */
export const fetchRecords = function (params, callback, callbackError) {
    let module = params.module;

    const url = '/api/' + module;
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const fetchRecord = function (params, callback, callbackError) {
    if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
        store.state[params.module].busy = false
    } else {
        window.detectChanges = false;
    }
    if (!window.detectChanges) {
        let module = params.module;
        let id = params.id;
        let url = null;
        if (id == 0)
            url = '/api/' + module;
        else
            url = '/api/' + module + '/' + id;
        if (params.estimator) {
            url += '?estimator=' + params.estimator
        }
        const instance = axios.create();
        instance
            .get(url)
            .then(response => {
                callback && callback(response);
            })
            .catch(error => {
                callbackError && callbackError(error);
            });
    }

}

export const fetchPaginateRecord = function (params, callback, callbackError) {
    let module = params.module;
    let apiURL = params.apiURL;
    let pageNo = params.page;
    let url = null;
    if (params.estimator) {
        url = '/api/' + module + '/' + apiURL + '?estimator=' + params.estimator + '&page=' + pageNo;
    } else {
        url = '/api/' + module + '/' + apiURL + '?page=' + pageNo;
    }
    // const url = '/api/' + module + '/' + apiURL + '?page=' + pageNo;
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}

export const saveRecord = function (params, data, callback, callbackError) {
    let module = params.module;
    window.detectChanges = false;
    const url = '/api/' + module;
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const updateMonumentInventory = function (params, data, callback, callbackError) {
    let module = params.module;
    const url = '/api/' + module + '/updateMInventory';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        })
}
export const deleteRecord = function (params, callback, callbackError) {
    let module = params.module;
    let id = params.id;

    const url = '/api/' + module + '/' + id;
    const instance = axios.create();
    instance
        .delete(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const getColumns = function (params, callback, callbackError) {
    let module = params.module;
    let columns = null;
    if ((params.column) && (params.column !== 'undefined')) {
        columns = params.column;
    } else {
        columns = 'columns';
    }
    const url = '/api/' + module + '/' + columns;
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const filterRecords = function (params, callback, callbackError) {
    let module = params.module;
    let data = params.filterData;
    let newUrl = null
    if (params.page) {
        let pageNo = params.page
        newUrl = '/api/' + module + '/search?page=' + pageNo;
    } else {
        newUrl = '/api/' + module + '/search';
    }

    // const url = '/api/' + module + '/search?page='+pageNo;
    const instance = axios.create();
    instance
        .post(newUrl, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const reportFilterRecord = function (params, callback, callbackError) {
    let data = params.filterData;
    let column = params.column;
    const url = '/api/report/' + column;
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const productCatalogRecord = function (params, callback, callbackError) {
    let data = params.filterData;
    let column = params.column;
    let module = params.methodName
    const url = '/api/' + module + '/' + column;
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response)
        })
        .catch(error => {
            callbackError && callbackError(error)
        })
}
export const firstRecord = function (params, callback, callbackError) {
    if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
        store.state[params.module].busy = false
    } else {
        window.detectChanges = false;
    }
    if (!window.detectChanges) {
        let module = params.module;
        const url = '/api/' + module + '/first';
        const instance = axios.create();
        instance
            .get(url)
            .then(response => {
                callback && callback(response);
            })
            .catch(error => {
                callbackError && callbackError(error);
            });
    }
}
export const lastRecord = function (params, callback, callbackError) {
    if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
        store.state[params.module].busy = false
    } else {
        window.detectChanges = false;
    }
    if (!window.detectChanges) {
        let module = params.module;
        const url = '/api/' + module + '/last';
        const instance = axios.create();
        instance
            .get(url)
            .then(response => {
                callback && callback(response);
            })
            .catch(error => {
                callbackError && callbackError(error);
            });
    }
}
export const nextRecord = function (params, callback, callbackError) {
    if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
        store.state[params.module].busy = false
    } else {
        window.detectChanges = false;
    }
    if (!window.detectChanges) {
        let module = params.module;
        let id = params.id;
        const url = '/api/' + module + '/next/' + id;
        const instance = axios.create();
        instance
            .get(url)
            .then(response => {
                callback && callback(response);
            })
            .catch(error => {
                callbackError && callbackError(error);
            });
    }
}
export const previousRecord = function (params, callback, callbackError) {
    if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
        store.state[params.module].busy = false
    } else {
        window.detectChanges = false;
    }
    if (!window.detectChanges) {
        let module = params.module;
        let id = params.id;
        const url = '/api/' + module + '/previous/' + id;
        const instance = axios.create();
        instance
            .get(url)
            .then(response => {
                callback && callback(response);
            })
            .catch(error => {
                callbackError && callbackError(error);
            });
    }
}
export const totalRecords = function (params, callback, callbackError) {
    let module = params.module
    const url = '/api/' + module + '/totalRecord'
    const instance = axios.create();
    instance
        .get(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const deleteProductFile = function (params, callback, callbackError) {
    let module = params.module;
    let id = params.id;
    let method = params.method;

    const url = '/api/' + module + method + id;
    // const url = '/api/' + module + '/deleteFile/' + id;
    const instance = axios.create();
    instance
        .post(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const downloadFile = function (params, callback, callbackError) {
    const url = '/api/download';
    const instance = axios.create();
    instance
        .post(url, params)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}
export const deleteProduct = function (params, callback, callbackError) {
    let module = params.module;
    let id = params.id;

    const url = '/api/' + module + id;
    const instance = axios.create();
    instance
        .post(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

export const updateRecord = function (params, data, callback, callbackError) {
    let module = params.module;
    let apiURL = params.apiURL;
    const url = '/api/' + module + '/' + apiURL;
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

export const sendMail = function (params, data, callback, callbackError) {
    let module = params.module;

    const url = '/api/' + module + '/mail';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};
export const EncodeDecodeData = function (data, callback, callbackError) {

    const url = '/api/collaboration/encodeDecodeData';
    const instance = axios.create();
    instance
        .post(url, data)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
};

export const syncOrders = function (params, callback, callbackError) {
    let module = params.module;

    const url = '/api/' + module + '/syncOrdersApi';
    const instance = axios.create();
    instance
        .post(url)
        .then(response => {
            callback && callback(response);
        })
        .catch(error => {
            callbackError && callbackError(error);
        });
}

