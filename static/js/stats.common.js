/* eslint no-unused-vars: "off" */
//
// LocalStorage helpers
//

var StoreTypes = {
  Boolean: {
    parse: function parse(str) {
      switch (str.toLowerCase()) {
        case '1':
        case 'true':
        case 'yes':
          return true
        default:
          return false
      }
    },
    stringify: function stringify(b) {
      return b ? 'true' : 'false'
    }
  },
  JSON: {
    parse: function parse(str) {
      return JSON.parse(str)
    },
    stringify: function stringify(json) {
      return JSON.stringify(json)
    }
  },
  String: {
    parse: function parse(str) {
      return str
    },
    stringify: function stringify(str) {
      return str
    }
  },
  Number: {
    parse: function parse(str) {
      return parseInt(str, 10)
    },
    stringify: function stringify(number) {
      return number.toString()
    }
  }

// set the default parameters here
}
var StoreOptions = {
  'geofence': {
    default: 'All',
    type: StoreTypes.String
  }
}

var Store = {
  getOption: function getOption(key) {
    var option = StoreOptions[key]
    if (!option) {
      throw new Error('Store key was not defined ' + key)
    }
    return option
  },
  get: function getKey(key) {
    var option = this.getOption(key)
    var optionType = option.type
    var rawValue = localStorage[key]
    if (rawValue === null || rawValue === undefined) {
      return option.default
    }
    return optionType.parse(rawValue)
  },
  set: function setKey(key, value) {
    var option = this.getOption(key)
    var optionType = option.type || StoreTypes.String
    localStorage[key] = optionType.stringify(value)
  },
  reset: function reset(key) {
    localStorage.removeItem(key)
  }
}
