FROM node:lts-alpine AS nodejs
WORKDIR /app
COPY package*.json ./
ENV HOST 0.0.0.0

FROM nodejs AS nuxt-dev
RUN npm install
ENV NODE_ENV development
EXPOSE 3000
CMD [ "npm", "run", "dev" ]
