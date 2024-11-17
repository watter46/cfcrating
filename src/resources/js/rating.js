window.ratingBgColor = (mom, rating) => {
    if (mom) {
        return '#285F88';
    }

    if (!rating)                       return '#6b7280'
    if (rating < 6.0)                  return '#EB1C23';
    if (6.0 <= rating && rating < 6.5) return '#FF7B00';
    if (6.5 <= rating && rating < 7.0) return '#F4BB00';
    if (7.0 <= rating && rating < 8)   return '#5CB400';
    if (8.0 <= rating && rating < 9.0) return '#009E9E';
    if (9.0 <= rating)                 return '#374DF5';
}

window.ratingRangeBgColor = (rating) => {
    if (!rating)                       return '#6b7280'
    if (rating < 6.0)                  return '#EB1C23';
    if (6.0 <= rating && rating < 6.5) return '#FF7B00';
    if (6.5 <= rating && rating < 7.0) return '#F4BB00';
    if (7.0 <= rating && rating < 8)   return '#5CB400';
    if (8.0 <= rating && rating < 9.0) return '#009E9E';
    if (9.0 <= rating)                 return '#374DF5';
}

window.ratingValue = (rating) => {
    if (!rating) {
        return 'ー';
    }
    
    if (Number.isInteger(Number(rating))) {        
        if (rating === 10) {
            return `${rating}`;
        }
        
        return `${rating}.0`;
    }

    return rating;
}