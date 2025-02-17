FROM node:lts-alpine AS base

WORKDIR /var/www/src


FROM base AS local

CMD ["npm", "start"]

FROM base AS production

CMD ["npm", "run", "build"]